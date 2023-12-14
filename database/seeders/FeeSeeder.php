<?php

namespace Database\Seeders;

use App\Models\Fee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Fee::create([
            'grade_id' => 1,
            'tuition' => 11180.40,
            'misc' => 5000.00,
            'books' => 6552.00,
        ]);

        Fee::create([
            'grade_id' => 2,
            'tuition' => 11180.40,
            'misc' => 5000.00,
            'books' => 6617.00,
        ]);

        Fee::create([
            'grade_id' => 3,
            'tuition' => 11180.40,
            'misc' => 5000.00,
            'books' => 6874.20,
        ]);

        Fee::create([
            'grade_id' => 4,
            'tuition' => 11180.40,
            'misc' => 5000.00,
            'books' => 7112.30,
        ]);

        Fee::create([
            'grade_id' => 5,
            'tuition' => 11180.40,
            'misc' => 5000.00,
            'books' => 7112.30,
        ]);

        Fee::create([
            'grade_id' => 6,
            'tuition' => 11180.40,
            'misc' => 5000.00,
            'books' => 7112.30,
        ]);

    }
}
