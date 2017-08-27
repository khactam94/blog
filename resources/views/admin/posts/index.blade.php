@extends('admin.layouts.app')

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

                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($posts as $key => $post)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $post->title }}</td>
                                <td>{{ \Illuminate\Support\Str::words(strip_tags($post->content), 55, '...') }}</td>
                                <td>{{ $post->user->name }}</td>
                                <td>{{ config('status')[$post->status] }}</td>
                                <td style="width:10%">
                                    <a class="btn btn-info btn-xs" href="{{ route('admin.posts.show',$post->id) }}" ><i class="glyphicon glyphicon-eye-open"></i></a>
                                    <a class="btn btn-primary btn-xs" href="{{ route('admin.posts.edit',$post->id) }}"><i class="glyphicon glyphicon-edit"></i></a>
                                    {!! Form::open(['method' => 'DELETE','route' => ['admin.posts.destroy', $post->id],'style'=>'display:inline']) !!}
                                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    {!! $posts->render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection