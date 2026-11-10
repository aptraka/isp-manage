<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCustomers = Customer::count();

        $activeCustomers = Customer::where(
            'status',
            'aktif'
        )->count();

        $suspendedCustomers = Customer::where(
            'status',
            'suspend'
        )->count();

        $disconnectedCustomers = Customer::where(
            'status',
            'terputus'
        )->count();

        $unpaidInvoices = Invoice::where(
            'payment_status',
            'belum_bayar'
        )->count();

        $monthlyInvoices = Invoice::select(
            DB::raw('MONTH(billing_period) as month'),
            DB::raw('SUM(amount) as total')
        )
            ->whereYear('billing_period', now()->year)
            ->groupBy(DB::raw('MONTH(billing_period)'))
            ->orderBy('month')
            ->get();

        $recentInvoices = Invoice::with('customer')
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'totalCustomers',
            'activeCustomers',
            'suspendedCustomers',
            'disconnectedCustomers',
            'unpaidInvoices',
            'monthlyInvoices',
            'recentInvoices'
        ));
    }
}
