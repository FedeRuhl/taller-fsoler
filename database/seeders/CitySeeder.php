<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Province;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // TODO: revisar porque no aparece, por ejemplo Cerrito
        $url = 'https://infra.datos.gob.ar/catalog/modernizacion/dataset/7/distribution/7.4/download/municipios.json';
        $cities = json_decode(file_get_contents($url), true)['municipios'];

        foreach($cities as $city)
        {
            $province = Province::create([
                'name' => $city['provincia']['nombre']
            ]);

            City::create([
                'name' => $city['nombre'],
                'province_id' => $province->id
            ]);
        }
    }
}
