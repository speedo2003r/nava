<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Seeder;

class CityTableSeeder extends Seeder
{
    public function run()
    {
        foreach(Country::get() as $country){
            for ($i = 1; $i < 10; $i++) {
                $data[] = [
                    'title_ar'   => "مدينة $i للدولة $country->id",
                    'title_en'   => "City $i country $country->id",
                    'country_id' => $country->id,
                ];
            }
        }
        City::insert($data);
    }
}
