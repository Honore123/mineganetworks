<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate(
            ['email'=>'admin@mineganetworks.rw'],
            ['name'=>'Administrator',
                'password'=>Hash::make('password'),
            ],
        );
    }
}
