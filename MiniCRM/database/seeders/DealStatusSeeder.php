<?php

namespace Database\Seeders;

use App\Models\DealStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DealStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ['Lead', 'Qualified', 'Negotiating', 'Won', 'Lost'];
        foreach ($names as $name) {
            DealStatus::create(['name' => $name]);
        }
    }
}
