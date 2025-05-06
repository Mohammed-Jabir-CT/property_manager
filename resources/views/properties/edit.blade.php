@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Edit Property</div>
            <div class="card-body">
                <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Title</label>
                        <input type="text" value="{{ $property->title }}" class="form-control" id="title"
                            name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" value="{{ $property->description }}" class="form-control" id="description"
                            name="description" required>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select name="type" id="type" class="form-select" required>
                            <option value="" disabled>Select Type</option>
                            <option value="rent" {{ $property->type == 'rent' ? 'selected' : '' }}>Rent</option>
                            <option value="sale" {{ $property->type == 'sale' ? 'selected' : '' }}>Sale</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" value="{{ $property->price }}" class="form-control" id="price"
                            name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" value="{{ $property->location }}" class="form-control" id="location"
                            name="location" required>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Region</label>
                        <select name="region_id" id="region_id" class="form-select" required>
                            <option value="" selected disabled>Select Region</option>
                            @foreach ($regions as $region)
                                <option value="{{ $region->id }}"
                                    {{ $property->region_id == $region->id ? 'selected' : '' }}>
                                    {{ $region->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @if ($property->featured_image)
                        <div class="mb-3">
                            <label for="current_image" class="form-label">Current Image</label>
                            <div>
                                <img src="{{ asset('storage/' . $property->featured_image) }}" alt="Current Image"
                                    class="img-fluid" style="max-height: 200px;">
                            </div>
                        </div>
                    @else
                        <span>No Image Uploaded</span>
                    @endif
                    <div class="mb-3">
                        <label for="featured_image" class="form-label">Replace Image</label>
                        <input type="file" class="form-control" id="featured_image" name="featured_image" required>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <button type="submit" class="btn btn-primary">Create Property</button>
                </form>
            </div>
        </div>
    </div>
@endsection
