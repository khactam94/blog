@extends('admin.layouts.app')

@section('css')
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://adminlte.io/themes/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <script src="{{ asset('vendor/bootstrap-confirmation/bootstrap-confirmation.min.js') }}"></script>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            Posts
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><a href="#">Posts</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Post List</h3>

                <div class="box-tools">
                    <a class="btn btn-success" href="{{ route('admin.posts.create') }}"> Create New Post</a>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                @if ($message = Session::get('error'))
                    <div class="alert alert-danger">
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

            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
                <div class="row" style="margin: 10px 0px">
                    <div class="btn-group text-left">
                        <div class="btn-group">
                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                Export <span class="caret"></span></button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ route('admin.posts.export', 'xlsx') }}">Excel</a></li>
                                <li><a href="{{ route('admin.posts.export', 'csv') }}">CSV</a></li>
                                <li><a href="{{ route('admin.posts.export', 'pdf') }}">PDF</a></li>
                            </ul>
                        </div>
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
    </section>
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

            $('.datatable tbody').on('click','button[data-toggle=confirmation]', function (e) {
                e.preventDefault();
                $('button[data-toggle=confirmation]').confirmation('show');
                document.querySelector('a[data-apply="confirmation"]').onclick = function(){
                    alert('xyz');
                };
            });
            $(document).on('click', 'a[data-apply=confirmation]',function(e){
                alert('abc');
                $(this).parents('form:first').submit();
            });
            $('[data-toggle=confirmation]').confirmation({
                rootSelector: '[data-toggle=confirmation]',
            });

        });
    </script>


@endsection