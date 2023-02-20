<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Place;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PlaceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return JsonResponse
     */
    protected $location_id;
    public function index($location_id): JsonResponse
    {
        $location = Location::find($location_id);
//        if (!$location) {
//            return response()->json(['error' => 'Location not found'], 404);
//        }
        $places = Place::where('location_id', $location_id)->get();
        return response()->json($places);
    }
    public function show($location_id, $id): JsonResponse
    {
        $location = Location::find($location_id);
        $place = Place::with('location')->find($id);
        if (!$place || !$location) {
            return response()->json(['error' => 'Place not found'], 404);
        }
        return response()->json($place);
    }
    /**
     * @throws ValidationException
     */
    public function create(request $request, $location_id): JsonResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'visited' => 'required|boolean',
        ]);

        $location = Location::find($location_id);
        if (!$location) {
            return response()->json(['error' => 'Location not found'], 404);
        }
        $place = new Place($request->all());
        $place->location()->associate($location);
        $place->save();
        return response()->json($place, 201);
    }
    /**
     * @throws ValidationException
     */
    public function update(request $request, $id): JsonResponse
    {
        $location = Location::find($request->input('location_id'));
        if (!$location) {
            return response()->json(['error' => 'Location not found'], 404);
        }
        $place = Place::find($id);
        if (!$place) {
            return response()->json(['error' => 'Place not found'], 404);
        }
        $this->validate($request, [
            'name' => 'required|unique:places,name,' . $id,
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'visited' => 'required|boolean',
            'location_id' => 'required|exists:locations,id',
        ]);
        $place->name = $request->input('name');
        $place->lat = $request->input('lat');
        $place->lng = $request->input('lng');
        $place->visited = $request->input('visited');
        $place->location()->associate($location);
        $place->save();

        return response()->json(['success update Place : '=>$id], 200);
    }

    public function delete($location_id,$id): JsonResponse
    {
        $location = Location::find($location_id);
        if (!$location) {
            return response()->json(['error' => 'Location not found'], 404);
        }
        $place = Place::find($id);
        if (!$place) {
            return response()->json(['error' => 'Place not found'], 404);
        }
        $place->delete();
        return response()->json(['message' => 'Place deleted']);
    }
    //
}
