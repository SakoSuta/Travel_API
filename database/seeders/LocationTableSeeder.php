<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Location::create(['name' => 'Paris', 'slug' => '', 'lat'=>'12.5', 'lng'=>'12.5']);
        Location::create(['name' => 'Lyon', 'slug' => '', 'lat'=>'12.12', 'lng'=>'12.12']);
        Location::create(['name' => 'Montpellier', 'slug' => '', 'lat'=>'12.55', 'lng'=>'12.55']);
    }}
