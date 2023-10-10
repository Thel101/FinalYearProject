<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $serviceCategories=[
            ['name'=> 'Blood Examination',
            'photo'=> 'photo.jpg'],
            ['name'=> 'Imaging',
            'photo'=> 'photo.jpg'],
            ['name'=> 'Vacinnation',
            'photo'=> 'photo.jpg'],
        ];
        foreach($serviceCategories as $sc)
        {
            ServiceCategory::create($sc);
        }
    }
}
