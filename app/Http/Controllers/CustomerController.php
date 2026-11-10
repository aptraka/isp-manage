<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\InternetPackage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::with('internetPackage');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $customers = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        $packages = InternetPackage::where(
            'is_active',
            true
        )->get();

        return view('customers.create', compact('packages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', 'unique:customers,phone'],
            'address' => ['required', 'string'],
            'package_id' => [
                'required',
                'exists:internet_packages,id',
            ],
            'status' => [
                'required',
                Rule::in(['aktif', 'suspend', 'terputus']),
            ],
        ]);

        $package = InternetPackage::findOrFail(
            $validated['package_id']
        );

        $validated['package_price'] = $package->price;

        Customer::create($validated);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function show(Customer $customer)
    {
        $customer->load([
            'internetPackage',
            'invoices' => fn($query) => $query->latest(),
        ]);

        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        $packages = InternetPackage::where(
            'is_active',
            true
        )->get();

        return view('customers.edit', compact(
            'customer',
            'packages'
        ));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => [
                'required',
                'string',
                'max:20',
                Rule::unique('customers', 'phone')->ignore($customer->id),
            ],
            'address' => ['required', 'string'],
            'package_id' => [
                'required',
                'exists:internet_packages,id',
            ],
            'status' => [
                'required',
                Rule::in(['aktif', 'suspend', 'terputus']),
            ],
        ]);

        $package = InternetPackage::findOrFail(
            $validated['package_id']
        );

        $validated['package_price'] = $package->price;

        $customer->update($validated);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Pelanggan berhasil diperbarui.');
    }

    public function destroy(Customer $customer)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $customer->delete();

        return redirect()
            ->route('customers.index')
            ->with('success', 'Pelanggan berhasil dihapus.');
    }
}
