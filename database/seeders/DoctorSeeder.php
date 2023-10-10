<?php

namespace Database\Seeders;

use App\Models\Clinics;
use App\Models\Doctors;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $doctors= [
            [
            "name" => "Dr Kyaw Kyaw Phyo",
            "license_no" => "192255",
            "email" => "kyawkyawphyo23@gmail.com",
            "phone" => "09783966898",
            "password" => Hash::make('P@$$w0rd'),
            "specialty_id" => 1,
            "degree" => "MBBS, Yangon",
            "experience" => "Has been practicing medical field for 10 years",
            "consultation_fees" => 10000,
            "consultation_duration" => "00:20:00",
            "photo" => "",
            ],
            [
            "name" => "Dr Thaw Thaw Han",
            "license_no" => "202255",
            "email" => "thawthawhan56@gmail.com",
            "phone" => "09443966898",
            "password" => Hash::make('P@$$w0rd'),
            "specialty_id" => 2,
            "degree" => "MBBS, Yangon",
            "experience" => "Has been practicing medical field for 10 years",
            "consultation_fees" => 10000,
            "consultation_duration" => "00:20:00",
            "photo" => "",
            ],
            [
            "name" => "Dr Phyo Nay Chi Maung",
            "license_no" => "212255",
            "email" => "chichimaung34@gmail.com",
            "phone" => "09443966898",
            "password" => Hash::make('P@$$w0rd'),
            "specialty_id" => 3,
            "degree" => "MBBS, Yangon",
            "experience" => "Has been practicing medical field for 10 years",
            "consultation_fees" => 10000,
            "consultation_duration" => "00:20:00",
            "photo" => "",
            ],
            [
            "name" => "Dr Phyo Pwint Thuzar",
            "license_no" => "203355",
            "email" => "phyopwint34@gmail.com",
            "phone" => "09449866898",
            "password" => Hash::make('P@$$w0rd'),
            "specialty_id" => 4,
            "degree" => "MBBS, Yangon",
            "experience" => "Has been practicing medical field for 10 years",
            "consultation_fees" => 10000,
            "consultation_duration" => "00:20:00",
            "photo" => "",
            ],
            [
                "name" => "Dr No No Eaindra Hlaing",
                "license_no" => "228755",
                "email" => "nonohlaing45@gmail.com",
                "phone" => "09559866898",
                "password" => Hash::make('P@$$w0rd'),
                "specialty_id" => 5,
                "degree" => "MBBS, Yangon",
                "experience" => "Has been practicing medical field for 10 years",
                "consultation_fees" => 10000,
                "consultation_duration" => "00:20:00",
                "photo" => ""
            ]
        ];
        foreach($doctors as $doctor){
            $doctor=Doctors::create($doctor);

            $clinics= Clinics::inRandomOrder()->limit(2)->get();
            $doctor->clinics()->attach($clinics,[
                'schedule_day'=> ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"][rand(1,2)],
                'start_time' => '07:00:00',
                'end_time' => '09:00:00'
            ]);
        }

    }
}
