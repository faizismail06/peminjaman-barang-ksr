<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $totalItems = Item::count();
        $totalBorrowings = Borrowing::count();
        $pendingBorrowings = Borrowing::where('status', 'pending')->count();
        $approvedBorrowings = Borrowing::where('status', 'approved')->count();

        $recentBorrowings = Borrowing::with(['borrowingItems.item'])->latest()->take(5)->get();
        $lowStockItems = Item::where('available_quantity', '<=', 5)
            ->where('available_quantity', '>', 0)
            ->orderBy('available_quantity', 'asc')
            ->take(5)
            ->get();


        return view('admin.dashboard', compact(
            'totalItems',
            'totalBorrowings',
            'pendingBorrowings',
            'approvedBorrowings',
            'recentBorrowings',
            'lowStockItems'
        ));
    }
}
