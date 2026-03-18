<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Role::create([
            'name' => 'Tele Caller',
            'alias' => 'TELECALLER',
            'status' => 1
        ]);

        Role::create([
            'name' => 'Sell Employee',
            'alias' => 'SELL_EMPLOYEE',
            'status' => 1
        ]);

        Role::create([
            'name' => 'Franchise Partner',
            'alias' => 'FRANCHISE_PARTNER',
            'status' => 1
        ]);

        Role::create([
            'name' => 'Accountant',
            'alias' => 'ACCOUNTANT',
            'status' => 1
        ]);
    }
}
