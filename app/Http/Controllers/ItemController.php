<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $items = Item::latest()->paginate(10);
        return view('admin.items.index', compact('items'));
    }

    public function create()
    {
        return view('admin.items.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:items,code',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'total_quantity' => 'required|integer|min:0',
            'condition' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['available_quantity'] = $validated['total_quantity'];

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('items', 'public');
        }

        Item::create($validated);

        return redirect()->route('admin.items.index')->with('success', 'Item berhasil ditambahkan!');
    }

    public function show(Item $item)
    {
        return view('admin.items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        return view('admin.items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:items,code,' . $item->id,
            'description' => 'nullable|string',
            'category' => 'required|string',
            'total_quantity' => 'required|integer|min:0',
            'condition' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update available quantity based on difference
        $difference = $validated['total_quantity'] - $item->total_quantity;
        $validated['available_quantity'] = $item->available_quantity + $difference;

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($item->photo) {
                Storage::disk('public')->delete($item->photo);
            }
            $validated['photo'] = $request->file('photo')->store('items', 'public');
        }

        $item->update($validated);

        return redirect()->route('admin.items.index')->with('success', 'Item berhasil diupdate!');
    }

    public function destroy(Item $item)
    {
        if ($item->photo) {
            Storage::disk('public')->delete($item->photo);
        }

        $item->delete();

        return redirect()->route('admin.items.index')->with('success', 'Item berhasil dihapus!');
    }
}
