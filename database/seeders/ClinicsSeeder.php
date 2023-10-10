<?php

namespace Database\Seeders;

use dump;
use App\Models\Clinics;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClinicsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Clinics::factory()->count(10)->create(); // Generate 10 clinic instances
    }
}
