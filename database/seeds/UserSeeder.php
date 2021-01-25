<?php

use App\User;
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

        $password = Hash::make('123456');

        User::create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => $password,
        ]);
    }
}
