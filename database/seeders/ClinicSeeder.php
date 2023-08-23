<?php

namespace Database\Seeders;

use App\Models\Clinics;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clincs =[
            [
                'name'=> 'Aung Clinic',
                'address'=> 'No.64 Baho Road',
                'township' => 'Mayangone',
                'phone'=> '01-522537',
                'status' => 1,
                'opening_hour' => '06:00:00',
                'closing_hour' => '22:00:00'
            ],
            [
                'name'=> 'SSC Clinic',
                'address'=> 'No.22 Mago Road',
                'township' => 'Tarmwe',
                'phone'=> '09-52253788',
                'status' => 1,
                'opening_hour' => '07:00:00',
                'closing_hour' => '21:00:00'],
            [
                'name'=> 'CLEAN Clinic',
                'address'=> 'No.12 Lath Road',
                'township' => 'Lanmadaw',
                'phone'=> '09-53353728',
                'status' => 1,
                'opening_hour' => '07:00:00',
                'closing_hour' => '21:00:00'
            ]
        ];
        foreach($clincs as $clinic){
            Clinics::create($clinic);
        };
    }
}
