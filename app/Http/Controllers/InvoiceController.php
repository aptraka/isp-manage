<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with('customer');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($customerQuery) use ($search) {
                        $customerQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where(
                'payment_status',
                $request->status
            );
        }

        $invoices = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $customers = Customer::where('status', 'aktif')->get();

        return view('invoices.create', compact('customers'));
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $validated = $request->validate([
            'customer_id' => [
                'required',
                'exists:customers,id',
            ],
            'billing_period' => [
                'required',
                'date',
                'date_format:Y-m-d',
            ],
        ]);

        $period = date(
            'Y-m-01',
            strtotime($validated['billing_period'])
        );

        $customer = Customer::findOrFail(
            $validated['customer_id']
        );

        if (Invoice::where('customer_id', $customer->id)
            ->where('billing_period', $period)
            ->exists()
        ) {
            return back()
                ->withErrors([
                    'billing_period' => 'Tagihan untuk pelanggan pada periode tersebut sudah ada.',
                ])
                ->withInput();
        }

        Invoice::create([
            'customer_id' => $customer->id,
            'invoice_number' => 'INV-' . $customer->id . '-' . date('Ym', strtotime($period)),
            'billing_period' => $period,
            'amount' => $customer->package_price,
            'payment_status' => 'belum_bayar',
        ]);

        return redirect()
            ->route('invoices.index')
            ->with('success', 'Tagihan berhasil dibuat.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('customer.internetPackage');

        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        abort(403);
    }

    public function update(Request $request, Invoice $invoice)
    {
        abort(403);
    }

    public function pay(Invoice $invoice)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        if ($invoice->payment_status === 'lunas') {
            return back()->with(
                'error',
                'Tagihan ini sudah lunas.'
            );
        }

        $invoice->update([
            'payment_status' => 'lunas',
            'paid_at' => now(),
        ]);

        return redirect()
            ->route('invoices.index')
            ->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    public function destroy(Invoice $invoice)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $invoice->delete();

        return redirect()
            ->route('invoices.index')
            ->with('success', 'Tagihan berhasil dihapus.');
    }
}
