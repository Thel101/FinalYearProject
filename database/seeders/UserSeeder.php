<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'name'=> 'admin',
            'email' => 'admin@gmail.com',
            'phone1' => '095004183',
            'phone2' => '095114183',
            'address'=> 'No.65 Baho Road Mayangone',
            'role' => 'admin',
            'password' => Hash::make('P@$$word')
        ]);
    }
}
