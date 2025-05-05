@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Manage Users</div>
            <div class="card-body">
                <a href="{{ route('properties.create') }}">
                    <button class="btn btn-primary">Create Property</button>
                </a>
                <div>
                    {{-- {{ $dataTable->table() }} --}}
                </div>
                <table class="table table-bordered data-table">
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
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th width="100px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function deleteProperty(id) {
            console.log(id);

            if (confirm('Are you sure you want to delete this property?')) {
                $.ajax({
                    type: "DELETE",
                    url: "properties/" + id,
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        alert(response.message);
                        location.href = "{{ route('properties.index') }}";
                    },
                });
            }
        }

        $(function() {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [0, 'asc']
                ],
                ajax: "{{ route('properties.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'location',
                        name: 'location'
                    },
                    {
                        data: 'region.name',
                        name: 'region.name'
                    },
                    {
                        data: 'featured_image',
                        name: 'featured_image',
                        render: function(data, type, row) {
                            url = `{{ asset('properties/${data}') }}`;
                            return '<img src="{{ asset("' + url + '") }}" width="50" height="50">';
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

        });
    </script>
@endsection
{{-- @push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush --}}
