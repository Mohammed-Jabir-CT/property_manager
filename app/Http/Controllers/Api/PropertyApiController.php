<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::with('region');

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        if ($request->has('region') && $request->region) {
            $query->where('region_id', $request->region);
        }

        $properties = $query->paginate(10);

        return PropertyResource::collection($properties);
    }
}
