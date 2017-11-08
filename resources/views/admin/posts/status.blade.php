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
                        <th style="width: 10%">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($posts as $key => $post)
                        <tr>
                            <td><input type="checkbox" class="sub_chk" data-id="{{$post->id}}"></td>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ \Illuminate\Support\Str::words(strip_tags($post->content), 115, '...') }}</td>
                            <td>{{ $post->user->name }}</td>
                            <td>
                                <a class="btn btn-info btn-xs" href="{{ route('my_posts.show',$post->id) }}">Show</a>
                                <a class="btn btn-primary btn-xs" href="{{ route('my_posts.edit',$post->id) }}">Edit</a>
                                {!! Form::open(['method' => 'DELETE','route' => ['my_posts.destroy', $post->id],'style'=>'display:inline']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $posts->appends(Request::only('q'))->render() !!}

            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
                <div class="row" style="margin: 10px 0px">
                    <div class="btn-group text-left">
                    </div>
                    <div class="btn-group" style="float: right;">
                        @if($status == 'pending')
                        <button class="btn btn-success approve">Approve</button>
                        <button class="btn btn-default cancel">Cancel</button>
                        @endif
                        <button class="btn btn-danger delete_all">Delete All</button>
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
            $('#master_chk').on('click', function (e) {
                if ($(this).is(':checked', true)) {
                    $(".sub_chk").prop('checked', true);
                    $(".sub_chk").parent().parent().addClass('selected')
                } else {
                    $(".sub_chk").prop('checked', false);
                    $(".sub_chk").parent().parent().removeClass('selected');
                }
            });

            $('.delete_all').on('click', function (e) {
                var allVals = [];
                $(".sub_chk:checked").each(function () {
                    allVals.push($(this).attr('data-id'));
                });
                if (allVals.length <= 0) {
                    alert("Please select row.");
                }
                else {
                    var check = confirm("Are you sure you want to delete this row?");
                    if (check == true) {

                        var join_selected_values = allVals.join(",");
                        console.log('Delete these posts: ', join_selected_values);
                        $.ajax({
                            url: '{{ route('admin.posts.deleteAll') }}',
                            type: 'DELETE',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: 'ids=' + join_selected_values,
                            success: function (data) {
                                if (data['success']) {
                                    $(".sub_chk:checked").each(function () {
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

                        $.each(allVals, function (index, value) {
                            $('table tr').filter("[data-row-id='" + value + "']").remove();
                        });
                    }
                }
            });
        });
    </script>


@endsection