<?php

namespace Database\Seeders;

use App\Models\MetricHistoryRun;
use App\Models\Strategy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MetricHistoryRunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all Strategy objects
        $strategies = Strategy::all();

        // Run two cycles of five.
        for($i = 0; $i < 2; $i++) {
            MetricHistoryRun::factory()
                ->count(5)
                ->for($strategies->shuffle()->first())
                ->create();
        }
    }
}
