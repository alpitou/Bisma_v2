<?php

// namespace Database\Seeds;

use App\Models\Moduls;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modul = [
            ['moduls_code' => '1000', 'moduls_name' => 'Setting', 'moduls_icon' => 'ph-gear', 'moduls_notes' => '-'],
        ];

        Moduls::insert($modul);
    }
}
