<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $totalOrders    = Order::where('buyer_id', $user->id)->count();
        $pendingOrders  = Order::where('buyer_id', $user->id)->where('status', 'pending')->count();
        $completedOrders= Order::where('buyer_id', $user->id)->where('status', 'completed')->count();
        $recentOrders   = Order::where('buyer_id', $user->id)
                                ->with(['seller', 'items.service'])
                                ->latest()
                                ->take(5)
                                ->get();

        return view('buyer.dashboard', compact('totalOrders', 'pendingOrders', 'completedOrders', 'recentOrders'));
    }

    public function services(Request $request)
    {
        $query    = $request->input('q');
        $category = $request->input('category');

        $services = Service::with('seller')
            ->where('is_active', true)
            ->when($query, fn($q) => $q->where('name', 'like', "%$query%")
                                       ->orWhere('description', 'like', "%$query%"))
            ->when($category, fn($q) => $q->where('category', $category))
            ->latest()
            ->paginate(12);

        return view('buyer.services.index', compact('services', 'query', 'category'));
    }

    public function serviceDetail(Service $service)
    {
        if (!$service->is_active) {
            abort(404);
        }
        return view('buyer.services.show', compact('service'));
    }
}

// tAMBAHAN
