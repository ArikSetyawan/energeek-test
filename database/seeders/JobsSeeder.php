<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $listJobs = ['Frontend Web Programmer', 'Fullstack Web Programmer', 'Quality Control'];
        foreach ($listJobs as $key => $value) {
            DB::table('jobs')->insert([
                'name' => $value,
            ]);
        }
    }
}
