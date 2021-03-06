@extends('layouts.app')

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
                            <a class="btn btn-success" href="{{ route('my_posts.create') }}"> Create New Post</a>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
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
                            <th width="200px">Action</th>
                        </tr>
                        @foreach ($posts as $key => $post)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $post->title }}</td>
                                <td>{{ \Illuminate\Support\Str::words(strip_tags($post->content), 115, '...') }}</td>
                                <td>{{ config('status')[$post->status] }}</td>
                                <td>
                                    <a class="btn btn-info btn-sm" href="{{ route('my_posts.show',$post->id) }}">Show</a>
                                    <a class="btn btn-primary btn-sm" href="{{ route('my_posts.edit',$post->id) }}">Edit</a>
                                    {!! Form::open(['method' => 'DELETE','route' => ['my_posts.destroy', $post->id],'style'=>'display:inline']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    {!! $posts->appends(Request::only('q'))->render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection