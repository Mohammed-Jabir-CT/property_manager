@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Create Property</div>
            <div class="card-body">
                <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Title</label>
                        <input type="text" value="{{ old('title') }}" class="form-control" id="title" name="title"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" value="{{ old('description') }}" class="form-control" id="description"
                            name="description" required>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select name="type" id="type" class="form-select" required>
                            <option value="" selected disabled>Select Type</option>
                            <option value="rent" {{ old('type') == 'rent' ? 'selected' : '' }}>Rent</option>
                            <option value="sale" {{ old('type') == 'sale' ? 'selected' : '' }}>Sale</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" value="{{ old('price') }}" class="form-control" id="price" name="price"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" value="{{ old('location') }}" class="form-control" id="location"
                            name="location" required>
                    </div>
                    <div class="mb-3">
                        <label for="region_id" class="form-label">Region</label>
                        <select name="region_id" id="region_id" class="form-select" required>
                            <option value="" selected disabled>Select Region</option>
                            @foreach ($regions as $region)
                                <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                    {{ $region->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="featured_image" class="form-label">Featured Image</label>
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
