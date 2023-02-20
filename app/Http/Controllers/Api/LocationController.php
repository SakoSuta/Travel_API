<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Place;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;

class LocationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $location = Location::with('place')->get();

        return response()->json($location);
    }

    public function show($id):JsonResponse
    {
        $location = Location::with('place')->find($id);

        if(!$location){
            return response()->json(['error' => 'Cette localisation n\'exite pas'], 404);
        }

        return response()->json($location);
    }

    public function create(request $request):JsonResponse
    {
        $this->validate($request, [
            "name" => "required|unique:locations",
            "lat" => "required|numeric",
            "lng" => "required|numeric"
        ]);

        ///
        $location = Location::create($request->all());
        $location->slug = Str::slug($location->name, '-');
        $location->save();
        return response()->json(["welcome" => 'La nouvelle location a bien était ajouter'], status:201);
    }

    public function update(request $request, $id):JsonResponse
    {
        $location = Location::find($id);

        if(!$location){
            return response()->json(['error' => 'Cette localisation n\'exite pas'], 404);
        }

        $this->validate($request, [
            "name" => "required|unique:locations,name,".$id,
            "lat" => "required|numeric",
            "lng" => "required|numeric"
        ]);

        // $location->slug = Str::slug($location->name, '.');
        $location->name = $request->input('name');
        $location->lat = $request->input('lat');
        $location->lng = $request->input('lng');
        $location->save();

        return response()->json(["success update" => $id], status:200);
    }

    public function delete($id):JsonResponse
    {
        $location = Location::find($id);

        if(!$location){
            return response()->json(['error' => 'Cette localisation n\'exite pas'], 404);
        }

        $location->delete();

        return response()->json(["message" => "Location deleted"], 201);
    }
    //
}