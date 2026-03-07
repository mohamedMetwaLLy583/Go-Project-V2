<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Show dashboard
     */
    public function index()
    {
        $stats = [
            'total_customers' => User::where('type', 1)->count(),
            'total_drivers' => User::where('type', 2)->count(),
            'active_drivers' => User::where('type', 2)->where('status', 1)->count(),
            'pending_drivers' => User::where('type', 2)->where('status', 0)->count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
            'open_tickets' => SupportTicket::where('status', 'pending')->count(),
            'total_balance' => User::sum('wallet_balance'),
        ];

        // Recent Drivers
        $recentDrivers = User::where('type', 2)
            ->latest()
            ->take(5)
            ->get();

        // Recent Orders
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Recent Tickets
        $recentTickets = SupportTicket::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentDrivers',
            'recentOrders',
            'recentTickets'
        ));
    }
}
