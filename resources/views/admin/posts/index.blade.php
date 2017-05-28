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
                            <a class="btn btn-success" href="{{ route('posts.create') }}"> Create New Post</a>
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
                            <th>Status</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($posts as $key => $post)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->view }}</td>
                                <td>{{ $post->status }}</td>
                                <td>
                                    <a class="btn btn-info" href="{{ route('posts.show',$post->id) }}">Show</a>
                                    <a class="btn btn-primary" href="{{ route('posts.edit',$post->id) }}">Edit</a>
                                    {!! Form::open(['method' => 'DELETE','route' => ['posts.destroy', $post->id],'style'=>'display:inline']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
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