<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\Place;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlaceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $paris = Location::where('name', 'Paris')->first();
        Place::create(['name' => 'Tour Eiffel', 'slug' => '', 'lat'=>'12.5', 'lng'=>'12.5', 'visited' => false, 'Location_id' => $paris->id]);
        Place::create(['name' => 'Champs-Elysées', 'slug' => '', 'lat'=>'12.12', 'lng'=>'12.12', 'visited' => false, 'Location_id' => $paris->id]);

        $lyon = Location::where('name', 'Lyon')->first();
        Place::create(['name' => 'Tour Eiffel', 'slug' => '', 'lat'=>'12.5', 'lng'=>'12.5', 'visited' => false, 'Location_id' => $lyon->id]);
        Place::create(['name' => 'Champs-Elysées', 'slug' => '', 'lat'=>'12.12', 'lng'=>'12.12', 'visited' => false, 'Location_id' => $lyon->id]);
    }
}
