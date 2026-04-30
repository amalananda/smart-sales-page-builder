<?php

namespace App\Http\Controllers;

use App\Models\SalesPage;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $recentPages = SalesPage::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        $totalPages = SalesPage::where('user_id', Auth::id())->count();
        $monthlyPages = SalesPage::where('user_id', Auth::id())
            ->whereMonth('created_at', now()->month)
            ->count();
        return view('dashboard', compact('recentPages', 'totalPages', 'monthlyPages'));
    }
}
