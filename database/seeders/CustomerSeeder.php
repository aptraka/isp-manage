<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\InternetPackage;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $basic = InternetPackage::where('name', 'Basic')->first();
        $standard = InternetPackage::where('name', 'Standard')->first();
        $premium = InternetPackage::where('name', 'Premium')->first();

        $customers = [
            [
                'name' => 'Budi Santoso',
                'phone' => '081234567001',
                'address' => 'Jl. Merdeka No. 10',
                'package_id' => $basic->id,
                'package_price' => $basic->price,
                'status' => 'aktif',
            ],
            [
                'name' => 'Andi Wijaya',
                'phone' => '081234567002',
                'address' => 'Jl. Sudirman No. 20',
                'package_id' => $standard->id,
                'package_price' => $standard->price,
                'status' => 'aktif',
            ],
            [
                'name' => 'Siti Rahma',
                'phone' => '081234567003',
                'address' => 'Jl. Diponegoro No. 30',
                'package_id' => $premium->id,
                'package_price' => $premium->price,
                'status' => 'suspend',
            ],
        ];

        foreach ($customers as $customer) {
            Customer::updateOrCreate(
                ['phone' => $customer['phone']],
                $customer
            );
        }
    }
}
