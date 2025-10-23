<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $items = Item::where('available_quantity', '>', 0)->latest()->take(6)->get();
        return view('home', compact('items'));
    }

    public function katalog(Request $request)
    {
        $query = Item::where('available_quantity', '>', 0);

        // Search filter
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Category filter
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        $items = $query->paginate(12);
        $categories = Item::select('category')->distinct()->pluck('category');
        return view('katalog', compact('items', 'categories'));
    }
}
