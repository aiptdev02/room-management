<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('plans')->insert([
            ['plan_name' => 'Plan A - Pay as you go', 'min_members' => 1, 'max_members' => 1000, 'monthly_fee' => 50.00],
            ['plan_name' => 'Plan B - Referral Fee', 'min_members' => 1, 'max_members' => 1000, 'monthly_fee' => 50.00],
        ]);
    }
}
