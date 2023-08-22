<?php

namespace Database\Seeders;

use App\Models\Specialty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specialties = [
            ['name' => 'General Practitioner'],
            ['name' => 'General Surgery'],
            ['name' => 'Cardiology'],
            ['name' => 'Urology'],
            ['name' => 'Obstetrics'],
        ];
        foreach ($specialties as $specialty) {
            Specialty::create($specialty);
        }
    }
}
