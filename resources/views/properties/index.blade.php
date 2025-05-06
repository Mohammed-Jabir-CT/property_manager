@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Properties</div>
        <div class="card-body">
            <a href="{{ route('properties.create') }}">
                <button class="btn btn-primary">Create Property</button>
            </a>
            <div class="row mt-3">
                <div class="col-md-2">
                    <input type="text" id="search-title" class="form-control" placeholder="Search Title">
                </div>
                <div class="col-md-2">
                    <input type="text" id="search-type" class="form-control" placeholder="Search Type">
                </div>
                <div class="col-md-2">
                    <input type="text" id="search-location" class="form-control" placeholder="Search Location">
                </div>
                <div class="col-md-2">
                    <select id="search-region" class="form-control">
                        <option value="">Select Region</option>
                        @foreach ($regions as $region)
                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="search-status" class="form-control">
                        <option value="">Select Status</option>
                        <option value="available">Available</option>
                        <option value="sold">Sold</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="input-group">
                        <input type="number" id="price-min" class="form-control" placeholder="Min Price">
                        <input type="number" id="price-max" class="form-control" placeholder="Max Price">
                    </div>
                </div>
            </div>
            <table class="table table-bordered data-table mt-3">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Location</th>
                        <th>Region</th>
                        <th>Featured Image</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th width="100px">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <form id="delete-form" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
    <script type="text/javascript">
        function deleteProperty(id) {
            if (confirm('Are you sure you want to delete this property?')) {
                $('#delete-form').attr('action', '{{ url('properties') }}/' + id).submit();
            }
        }
        $(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                order: [
                    [0, 'asc']
                ],
                ajax: {
                    url: "{{ route('properties.index') }}",
                    data: function(d) {
                        d.title = $('#search-title').val();
                        d.type = $('#search-type').val();
                        d.location = $('#search-location').val();
                        d.region = $('#search-region').val();
                        d.status = $('#search-status').val();
                        d.price_min = $('#price-min').val();
                        d.price_max = $('#price-max').val();
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'title',
                        name: 'title',
                        orderable: false
                    },
                    {
                        data: 'description',
                        name: 'description',
                        orderable: false
                    },
                    {
                        data: 'type',
                        name: 'type',
                        orderable: false
                    },
                    {
                        data: 'price',
                        name: 'price',
                    },
                    {
                        data: 'location',
                        name: 'location',
                        orderable: false
                    },
                    {
                        data: 'region.name',
                        name: 'region.name',
                        orderable: false
                    },
                    {
                        data: 'image',
                        name: 'image',
                        orderable: false
                    },
                    {
                        data: 'status',
                        name: 'status',
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('#search-title, #search-type, #search-location, #search-region, #search-status, #price-min, #price-max')
                .on(
                    'keyup change',
                    function() {
                        table.draw();
                    });
        });
    </script>
@endsection
