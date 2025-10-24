<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\BorrowingItem;
use App\Models\Item;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BorrowingController extends Controller
{
    private function getSessionId()
    {
        if (!session()->has('cart_session_id')) {
            session(['cart_session_id' => Str::uuid()]);
        }
        return session('cart_session_id');
    }

    // Public Methods (No Auth Required)
    public function index()
    {
        $items = Item::where('available_quantity', '>', 0)->get();
        return view('borrowings.index', compact('items'));
    }

    public function create()
    {
        $sessionId = $this->getSessionId();
        $cartItems = Cart::where('session_id', $sessionId)->with('item')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('katalog')->with('error', 'Keranjang masih kosong! Silakan pilih barang terlebih dahulu.');
        }

        return view('borrowings.create', compact('cartItems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'borrower_name' => 'required|string|max:255',
            'phone' => 'required|string',
            'organization' => 'nullable|string',
            'borrow_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after:borrow_date',
            'purpose' => 'required|string',
            'spj' => 'required|file|mimes:pdf|max:5120', // Max 5MB
        ]);

        $sessionId = $this->getSessionId();
        $cartItems = Cart::where('session_id', $sessionId)->with('item')->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Keranjang kosong!')->withInput();
        }

        // Upload SPJ
        $spjPath = $request->file('spj')->store('spj', 'public');

        // Hitung total hari dan total biaya
        $borrowDate = \Carbon\Carbon::parse($validated['borrow_date']);
        $returnDate = \Carbon\Carbon::parse($validated['return_date']);
        $totalDays = $borrowDate->diffInDays($returnDate) + 1; // +1 untuk hari pertama

        $totalCost = 0;
        $itemsToCheck = [];

        // Validasi stok dan hitung total biaya
        foreach ($cartItems as $cartItem) {
            if (!$cartItem->item->isAvailable($cartItem->quantity)) {
                return back()->with('error', "Stok {$cartItem->item->name} tidak mencukupi!")->withInput();
            }

            $subtotal = $cartItem->quantity * $cartItem->item->price * $totalDays;
            $totalCost += $subtotal;

            $itemsToCheck[] = [
                'item' => $cartItem->item,
                'quantity' => $cartItem->quantity,
            ];
        }

        DB::beginTransaction();
        try {
            // Buat borrowing
            $borrowing = Borrowing::create([
                'borrower_name' => $validated['borrower_name'],
                'phone' => $validated['phone'],
                'organization' => $validated['organization'],
                'borrow_date' => $validated['borrow_date'],
                'return_date' => $validated['return_date'],
                'total_days' => $totalDays,
                'total_cost' => $totalCost,
                'purpose' => $validated['purpose'],
                'spj' => $spjPath,
                'status' => 'pending',
            ]);

            // Simpan borrowing items
            foreach ($cartItems as $cartItem) {
                BorrowingItem::create([
                    'borrowing_id' => $borrowing->id,
                    'item_id' => $cartItem->item_id,
                    'quantity' => $cartItem->quantity,
                    'price_per_day' => $cartItem->item->price,
                ]);
            }

            // Hapus cart
            Cart::where('session_id', $sessionId)->delete();

            DB::commit();

            return redirect()->route('borrowings.success', ['code' => $borrowing->code_number])
                ->with('success', 'Pengajuan peminjaman berhasil dikirim!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function success(Request $request)
    {
        $codeNumber = $request->get('code');
        $borrowing = null;

        if ($codeNumber) {
            $borrowing = Borrowing::where('code_number', $codeNumber)
                ->with(['borrowingItems.item'])
                ->first();
        }

        return view('borrowings.success', compact('borrowing'));
    }

    public function track(Request $request)
    {
        $borrowing = null;

        if ($request->has('code')) {
            $borrowing = Borrowing::where('code_number', $request->code)
                ->with(['borrowingItems.item', 'approver'])
                ->first();
        }

        return view('borrowings.track', compact('borrowing'));
    }

    // Admin Methods (Auth Required)
    public function adminIndex(Request $request)
    {
        $query = Borrowing::with(['borrowingItems.item', 'approver'])->latest();

        // Filter by status if provided
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $borrowings = $query->paginate(15);
        return view('admin.borrowings.index', compact('borrowings'));
    }

    public function show(Borrowing $borrowing)
    {
        $borrowing->load(['borrowingItems.item', 'approver']);
        return view('admin.borrowings.show', compact('borrowing'));
    }

    public function approve(Request $request, Borrowing $borrowing)
    {
        if ($borrowing->status !== 'pending') {
            return back()->with('error', 'Peminjaman ini sudah diproses!');
        }

        DB::beginTransaction();
        try {
            // Cek dan kurangi stok untuk setiap item
            foreach ($borrowing->borrowingItems as $borrowingItem) {
                $item = $borrowingItem->item;

                if (!$item->isAvailable($borrowingItem->quantity)) {
                    DB::rollBack();
                    return back()->with('error', "Stok {$item->name} tidak mencukupi!");
                }

                $item->available_quantity -= $borrowingItem->quantity;
                $item->save();
            }

            // Approve borrowing
            $borrowing->update([
                'status' => 'approved',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
                'admin_notes' => $request->admin_notes,
            ]);

            DB::commit();
            return redirect()->route('admin.borrowings.index')->with('success', 'Peminjaman berhasil disetujui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, Borrowing $borrowing)
    {
        if ($borrowing->status !== 'pending') {
            return back()->with('error', 'Peminjaman ini sudah diproses!');
        }

        $borrowing->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->route('admin.borrowings.index')->with('success', 'Peminjaman berhasil ditolak!');
    }

    public function returned(Borrowing $borrowing)
    {
        if ($borrowing->status !== 'approved') {
            return back()->with('error', 'Peminjaman belum disetujui atau sudah dikembalikan!');
        }

        DB::beginTransaction();
        try {
            // Kembalikan stok untuk setiap item
            foreach ($borrowing->borrowingItems as $borrowingItem) {
                $item = $borrowingItem->item;
                $item->available_quantity += $borrowingItem->quantity;
                $item->save();
            }

            // Update status
            $borrowing->update([
                'status' => 'returned',
            ]);

            DB::commit();
            return redirect()->route('admin.borrowings.index')->with('success', 'Barang berhasil dikembalikan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
