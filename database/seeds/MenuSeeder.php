<?php

use App\Models\Menus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menu = [
            ['menus_code' => '1001', 'moduls_code' => '1000', 'menus_name' => 'User', 'menus_route' => 'users', 'menus_notes' => '-'],
            ['menus_code' => '1002', 'moduls_code' => '1000', 'menus_name' => 'Perminssion', 'menus_route' => 'permission', 'menus_notes' => '-'],
            ['menus_code' => '1003', 'moduls_code' => '1000', 'menus_name' => 'Modul', 'menus_route' => 'moduls', 'menus_notes' => '-'],
            ['menus_code' => '1004', 'moduls_code' => '1000', 'menus_name' => 'Menu', 'menus_route' => 'menus', 'menus_notes' => '-'],
            ['menus_code' => '1005', 'moduls_code' => '1000', 'menus_name' => 'Submenu', 'menus_route' => 'submenus', 'menus_notes' => '-'],
            ['menus_code' => '1006', 'moduls_code' => '1000', 'menus_name' => 'Level', 'menus_route' => 'levels', 'menus_notes' => '-'],
            ['menus_code' => '1007', 'moduls_code' => '1000', 'menus_name' => 'Company', 'menus_route' => 'companies', 'menus_notes' => '-'],
            ['menus_code' => '1008', 'moduls_code' => '1000', 'menus_name' => 'Division', 'menus_route' => 'divisions', 'menus_notes' => '-'],
            ['menus_code' => '1009', 'moduls_code' => '1000', 'menus_name' => 'Department', 'menus_route' => 'departments', 'menus_notes' => '-'],
            ['menus_code' => '1010', 'moduls_code' => '1000', 'menus_name' => 'Homebase', 'menus_route' => 'homebases', 'menus_notes' => '-'],
            ['menus_code' => '1011', 'moduls_code' => '1000', 'menus_name' => 'Shift', 'menus_route' => 'shifts', 'menus_notes' => '-'],
            ['menus_code' => '1012', 'moduls_code' => '1000', 'menus_name' => 'Master Approval', 'menus_route' => 'master_approvals', 'menus_notes' => '-'],
            ['menus_code' => '1013', 'moduls_code' => '1000', 'menus_name' => 'Province', 'menus_route' => 'provinces', 'menus_notes' => '-'],
            ['menus_code' => '1014', 'moduls_code' => '1000', 'menus_name' => 'City', 'menus_route' => 'cities', 'menus_notes' => '-'],
            ['menus_code' => '1015', 'moduls_code' => '1000', 'menus_name' => 'District', 'menus_route' => 'districts', 'menus_notes' => '-'],
        ];

        Menus::insert($menu);
    }
}
