<?php

namespace Database\Seeders;

use App\Models\Downpayment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DownPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Downpayment::create([
            'down_payment' => 2750.00,
        ]);
    }
}
