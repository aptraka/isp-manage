<?php

namespace Database\Seeders;

use App\Models\InternetPackage;
use Illuminate\Database\Seeder;

class InternetPackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Basic',
                'speed' => '10 Mbps',
                'price' => 150000,
                'description' => 'Paket internet untuk kebutuhan ringan.',
                'is_active' => true,
            ],
            [
                'name' => 'Standard',
                'speed' => '20 Mbps',
                'price' => 250000,
                'description' => 'Paket internet untuk keluarga.',
                'is_active' => true,
            ],
            [
                'name' => 'Premium',
                'speed' => '50 Mbps',
                'price' => 400000,
                'description' => 'Paket internet untuk kebutuhan intensif.',
                'is_active' => true,
            ],
            [
                'name' => 'Business',
                'speed' => '100 Mbps',
                'price' => 750000,
                'description' => 'Paket internet untuk bisnis.',
                'is_active' => true,
            ],
        ];

        foreach ($packages as $package) {
            InternetPackage::updateOrCreate(
                ['name' => $package['name']],
                $package
            );
        }
    }
}
