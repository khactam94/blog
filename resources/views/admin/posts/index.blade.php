@extends('admin.layouts.app')

@section('css')
    @include('layouts.datatables_css')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="pull-left" style="margin-left: 20px">
                            <h2>Post List</h2>
                        </div>
                        <div class="pull-right" style="margin: 20px">
                            <a class="btn btn-success" href="{{ route('admin.posts.create') }}"> Create New Post</a>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <table class="table table-bordered datatable" style="width: 100%">
                        <thead>
                            <tr>
                                <th style="width: 5%">Id</th>
                                <th style="width: 30%">Title</th>
                                <th style="width: 40%">Content</th>
                                <th style="width: 10%">Author</th>
                                <th style="width: 5%">Status</th>
                                <th style="width: 10%">Action</th>
                            </tr>
                        </thead>

                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('layouts.datatables_js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.posts.list') }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'title', name: 'title'},
                    {data: 'content', name: 'content'},
                    {data: 'user_id', name: 'user_id'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', searchable: "false", orderable: "false"},
                ],
            });
        });
    </script>
@endsection