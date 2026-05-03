<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SellerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        $totalServices   = Service::where('seller_id', $user->id)->count();
        $activeServices  = Service::where('seller_id', $user->id)->where('is_active', true)->count();
        $totalOrders     = Order::where('seller_id', $user->id)->count();
        $pendingOrders   = Order::where('seller_id', $user->id)->where('status', 'pending')->count();
        $completedOrders = Order::where('seller_id', $user->id)->where('status', 'completed')->count();
        $totalRevenue    = Order::where('seller_id', $user->id)
                                ->where('status', 'completed')
                                ->sum('total_price');

        $recentOrders = Order::where('seller_id', $user->id)
                              ->with(['buyer', 'items.service'])
                              ->latest()
                              ->take(5)
                              ->get();

        // Monthly revenue chart data
        $monthlyRevenue = Order::where('seller_id', $user->id)
            ->where('status', 'completed')
            ->selectRaw('MONTH(created_at) as month, SUM(total_price) as revenue')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('seller.dashboard', compact(
            'totalServices', 'activeServices', 'totalOrders',
            'pendingOrders', 'completedOrders', 'totalRevenue',
            'recentOrders', 'monthlyRevenue'
        ));
    }
}
