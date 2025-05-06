<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Property::with('region');

            if ($request->title) {
                $query->where('title', 'like', '%' . $request->title . '%');
            }

            if ($request->type) {
                $query->where('type', 'like', '%' . $request->type . '%');
            }

            if ($request->location) {
                $query->where('location', 'like', '%' . $request->location . '%');
            }

            if ($request->region) {
                $query->where('region_id', $request->region);
            }

            if ($request->status) {
                $query->where('status', $request->status);
            }

            if ($request->price_min) {
                $query->where('price', '>=', $request->price_min);
            }

            if ($request->price_max) {
                $query->where('price', '<=', $request->price_max);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $edit = route('properties.edit', $row->id);
                    $delete = $row->id;
                    $editBtn = '<a href="' . $edit . '" class="edit btn btn-warning btn-sm">Edit</a>';
                    $deleteBtn = '<a onclick="deleteProperty(' . $delete . ')" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $editBtn . ' ' . $deleteBtn;
                })
                ->addColumn('image', function ($row) {
                    if ($row->featured_image) {
                        $url = Storage::url($row->featured_image);
                        return '<img src="' . $url . '" alt="Property Image" style="width: 50px; height: 50px; object-fit: cover;">';
                    } else {
                        return '<span>No Image</span>';
                    }
                })
                ->rawColumns(['action', 'image'])
                ->make(true);
        }

        $regions = Region::all();
        return view('properties.index', compact('regions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $regions = Region::all();
        return view('properties.create', [
            'regions' => $regions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:rent,sale',
            'price' => 'required|integer|min:0',
            'location' => 'required|string|max:255',
            'region_id' => 'required|exists:regions,id',
            'featured_image' => 'required|file|mimetypes:image/jpeg,image/png,image/gif,image/svg+xml|max:2048'
        ]);


        $property = new Property();
        $property->title = $request->title;
        $property->description = $request->description;
        $property->type = $request->type;
        $property->price = $request->price;
        $property->location = $request->location;
        $property->region_id = $request->region_id;
        $property->status = 'available';

        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('properties', 'public');
            $property->featured_image = $imagePath;
        }
        $property->save();

        return redirect()->route('properties.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        return view('properties.show', [
            'property' => $property
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        $regions = Region::all();
        return view('properties.edit', [
            'regions' => $regions,
            'property' => $property
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:rent,sale',
            'price' => 'required|integer|min:0',
            'location' => 'required|string|max:255',
            'region_id' => 'nullable|exists:regions,id',
            'status' => 'required|in:available,pending,sold',
            'featured_image' => 'nullable|image|max:2048'
        ]);

        $property->title = $request->title;
        $property->description = $request->description;
        $property->type = $request->type;
        $property->price = $request->price;
        $property->location = $request->location;
        $property->region_id = $request->region_id;
        $property->status = $request->status;
        if ($request->hasFile('featured_image')) {
            if ($property->featured_image) {
                Storage::disk('public')->delete($property->featured_image);
            }
            $imagePath = $request->file('featured_image')->store('properties', 'public');
            $property->featured_image = $imagePath;
        }
        $property->save();
        return redirect()->route('properties.show', ['property' => $property]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        $property->delete();

        return redirect()->route('properties.index');
    }
}
