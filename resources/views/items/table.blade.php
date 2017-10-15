@section('css')
    @include('layouts.datatables_css')
@endsection


<table class="table table-hover table-bordered table-striped datatable" style="width:100%">
    <thead>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Description</th>
        <th>Action</th>
    </tr>
    </thead>
</table>

@section('scripts')
    @include('layouts.datatables_js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('items.list') }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'description', name: 'description'},
                    {data: 'action', name: 'action', searchable: "false", orderable: "false"},
                ],
            });
        });
    </script>
@endsection