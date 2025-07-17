<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Designations
        DB::table('designations')->insert([
            ['title' => 'Manager', 'code' => '12'],
            ['title' => 'Assistant Manager', 'code' => '14'],
            ['title' => 'Officer', 'code' => '16'],
        ]);

        // Seed Departments
        DB::table('departments')->insert([
            ['name' => 'HR', 'code'=>'302'],
            ['name' => 'Finance', 'code'=>'802'],
            ['name' => 'Court', 'code'=>'873'],

        ]);

        // Seed Offices
        DB::table('offices')->insert([
           ['title'=>'DC ' , 'address'=>'Danyoure', 'contact'=>'1234567890'],
           ['title'=>'AC' , 'address'=>'gilgit', 'contact'=>'343434334132'],
           ['title'=>'Scholarship' , 'address'=>'kashrote', 'contact'=>'125345345'],
        ]);

        // Seed Folders
        DB::table('folders')->insert([
            ['title' => 'General','code'=>'434'],
            ['title' => 'personal','code'=>'21'],
            ['title' => 'Doucuments','code'=>'44'],

        ]);

        // Seed Flags
        DB::table('flags')->insert([
            ['title' => 'Red','code'=>'56'],
            ['title' => 'Blue','code'=>'22'],
            ['title' => 'Green','code'=>'67'],
        ]);
    }
}
