<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $period = now()->startOfMonth();

        $customers = Customer::all();

        foreach ($customers as $customer) {
            Invoice::updateOrCreate(
                [
                    'customer_id' => $customer->id,
                    'billing_period' => $period->toDateString(),
                ],
                [
                    'invoice_number' => 'INV-' . $customer->id . '-' . $period->format('Ym'),
                    'amount' => $customer->package_price,
                    'payment_status' => 'belum_bayar',
                    'paid_at' => null,
                ]
            );
        }
    }
}
