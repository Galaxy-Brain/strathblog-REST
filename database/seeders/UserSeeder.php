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
        User::create([
            'name'=>'Steve Nyanumba',
            'email'=>'stevennmb9@gmail.com',
            'password'=>Hash::make("1234567890")
        ]);
        User::create([
            'name'=>'Administrator',
            'email'=>'admin@galaxybrain.com',
            'password'=>Hash::make("1234567890"),
            'is_admin'=>true,
        ]);
    }
}
