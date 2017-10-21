@extends('admin.layouts.app')

@section('css')
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="{{ asset('vendor/bootstrap-confirmation/bootstrap-confirmation.min.js') }}"></script>
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
                                <th style="width: 5%"><input type="checkbox" id="master_chk"></th>
                                <th style="width: 5%">Id</th>
                                <th style="width: 30%">Title</th>
                                <th style="width: 40%">Content</th>
                                <th style="width: 5%">Author</th>
                                <th style="width: 5%">Status</th>
                                <th style="width: 10%">Action</th>
                            </tr>
                        </thead>

                    </table>
                    <div class="row" style="margin: 10px 0px">
                        <div class="btn-group text-left">
                            <a href="{{ route('admin.posts.export') }}" class="btn btn-info">Export</a>
                            <button class="btn btn-info"  data-toggle="collapse" data-target="#importPost">Import</button>
                        </div>
                        <div class="btn-group" style="float: right;">
                            <button class="btn btn-danger delete_all">Delete All Selected Records</button>
                        </div>
                    </div>
                    <div class="row collapse" style="margin: 10px 0px" id="importPost">
                        <div class="col-md-3">
                            <form role="form" action="{{ route('admin.posts.import') }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="exampleInputFile">File input</label>
                                        <input type="file" id="excelFile" name="excelFile">

                                        <p class="help-block">Example block-level help text here.</p>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var selected = [];
            $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.posts.list') }}',
                columns: [
                    {data: 'checkbox', name: 'checkbox', searchable: false, orderable: false},
                    {data: 'id', name: 'id'},
                    {data: 'title', name: 'title'},
                    {data: 'content', name: 'content'},
                    {data: 'user_id', name: 'user_id'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', searchable: false, orderable: false},
                ],
            });

            $('.datatable').on('change', '.sub_chk', function(e) {
                $(this).is(':checked',true) ? $(this).parent().parent().addClass('selected')
                    : $(this).parent().parent().removeClass('selected');
            });
            $('#master_chk').on('click', function(e) {
                if($(this).is(':checked',true))
                {
                    $(".sub_chk").prop('checked', true);
                    $(".sub_chk").parent().parent().addClass('selected')
                } else {
                    $(".sub_chk").prop('checked',false);
                    $(".sub_chk").parent().parent().removeClass('selected');
                }
            });

            $('.delete_all').on('click', function(e) {

                var allVals = [];
                $(".sub_chk:checked").each(function() {
                    allVals.push($(this).attr('data-id'));
                });

                if(allVals.length <=0)
                {
                    alert("Please select row.");
                }  else {

                    var check = confirm("Are you sure you want to delete this row?");
                    if(check == true){

                        var join_selected_values = allVals.join(",");
                        console.log('Delete these posts: ', join_selected_values);
                        $.ajax({
                            url: '{{ route('admin.posts.deleteAll') }}',
                            type: 'DELETE',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: 'ids='+join_selected_values,
                            success: function (data) {
                                if (data['success']) {
                                    $(".sub_chk:checked").each(function() {
                                        $(this).parents("tr").remove();
                                    });
                                    alert(data['success']);
                                } else if (data['error']) {
                                    alert(data['error']);
                                } else {
                                    alert('Whoops Something went wrong!!');
                                }
                            },
                            error: function (data) {
                                alert(data.responseText);
                            }
                        });

                        $.each(allVals, function( index, value ) {
                            $('table tr').filter("[data-row-id='" + value + "']").remove();
                        });
                    }
                }
            });

            $('[data-toggle=confirmation]').confirmation({
                rootSelector: '[data-toggle=confirmation]',
                // other options
            });
        });
    </script>


@endsection