<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            [
                "name"=> "Full Blood Flim",
                "photo"=>"bloodfilm,jpg",
                "category_id"=>1,
                "clinic_id"=> 1,
                "description"=> "Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,
                molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum
                numquam blanditiis harum quisquam eius sed odit fugiat",
                "components"=> ["Red Blood Cells Count",
            "White Blood Cells Count",
            "Platelet Count"],
            "price"=> 250000,
            "promotion_rate"=> 0,
            "promotion"=> 0

            ],
            [
                "name"=> "Full Blood Flim",
                "photo"=>"bloodfilm,jpg",
                "category_id"=>2,
                "clinic_id"=> 1,
                "description"=> "Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,
                molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum
                numquam blanditiis harum quisquam eius sed odit fugiat",
                "components"=> ["Red Blood Cells Count",
            "White Blood Cells Count",
            "Platelet Count"],
            "price"=> 250000,
            "promotion_rate"=> 0,
            "promotion"=> 0
            ],
            [
                "name"=> "Full Blood Flim",
                "photo"=>"bloodfilm,jpg",
                "category_id"=>1,
                "clinic_id"=> 2,
                "description"=> "Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,
                molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum
                numquam blanditiis harum quisquam eius sed odit fugiat",
                "components"=> ["Red Blood Cells Count",
            "White Blood Cells Count",
            "Platelet Count"],
            "price"=> 250000,
            "promotion_rate"=> 0,
            "promotion"=> 0
            ],
        ];
    }
}
