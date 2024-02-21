<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $listSkills = ['PHP', 'PostgreSQL','API (JSON,REST)', 'Version Control System (Github, Gitlab)'];
        foreach ($listSkills as $key => $value) {
            DB::table('skills')->insert([
                'name' => $value,
            ]);
        }
    }
}
