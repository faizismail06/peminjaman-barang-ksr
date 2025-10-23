<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    // Public Methods (No Auth Required)
    public function index()
    {
        $items = Item::where('available_quantity', '>', 0)->get();
        return view('borrowings.index', compact('items'));
    }

    public function create(Request $request)
    {
        $itemId = $request->query('item');

        if (!$itemId) {
            return redirect()->route('katalog')->with('error', 'Silakan pilih barang terlebih dahulu!');
        }

        $item = Item::where('id', $itemId)
            ->where('available_quantity', '>', 0)
            ->firstOrFail();

        return view('borrowings.create', compact('item'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'borrower_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'organization' => 'nullable|string',
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'borrow_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after:borrow_date',
            'purpose' => 'required|string',
        ]);

        $item = Item::findOrFail($validated['item_id']);

        if (!$item->isAvailable($validated['quantity'])) {
            return back()->with('error', 'Jumlah barang yang tersedia tidak mencukupi!')->withInput();
        }

        Borrowing::create($validated);

        return redirect()->route('borrowings.success')->with('success', 'Pengajuan peminjaman berhasil dikirim! Silakan tunggu konfirmasi dari admin.');
    }

    public function success()
    {
        return view('borrowings.success');
    }

    // Admin Methods (Auth Required)
    public function adminIndex(Request $request)
    {
        $query = Borrowing::with(['item', 'approver'])->latest();

        // Filter by status if provided
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $borrowings = $query->paginate(15);
        return view('admin.borrowings.index', compact('borrowings'));
    }

    public function show(Borrowing $borrowing)
    {
        $borrowing->load(['item', 'approver']);
        return view('admin.borrowings.show', compact('borrowing'));
    }

    public function approve(Request $request, Borrowing $borrowing)
    {
        if ($borrowing->status !== 'pending') {
            return back()->with('error', 'Peminjaman ini sudah diproses!');
        }

        $item = $borrowing->item;

        if (!$item->isAvailable($borrowing->quantity)) {
            return back()->with('error', 'Jumlah barang yang tersedia tidak mencukupi!');
        }

        // Update stock
        $item->available_quantity -= $borrowing->quantity;
        $item->save();

        // Approve borrowing
        $borrowing->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->route('admin.borrowings.index')->with('success', 'Peminjaman berhasil disetujui!');
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

        // Return stock
        $item = $borrowing->item;
        $item->available_quantity += $borrowing->quantity;
        $item->save();

        // Update status
        $borrowing->update([
            'status' => 'returned',
        ]);

        return redirect()->route('admin.borrowings.index')->with('success', 'Barang berhasil dikembalikan!');
    }
}
