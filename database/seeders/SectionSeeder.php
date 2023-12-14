<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Section::create([
            'grade_id' => 1,
            'name' => 'Rose',
        ]);

        Section::create([
            'grade_id' => 2,
            'name' => 'Sunflower',
        ]);

        Section::create([
            'grade_id' => 3,
            'name' => 'Tulip',
        ]);

        Section::create([
            'grade_id' => 4,
            'name' => 'Daisy',
        ]);

        Section::create([
            'grade_id' => 5,
            'name' => 'Lily',
        ]);

        Section::create([
            'grade_id' => 6,
            'name' => 'Orchid',
        ]);
    }
}
