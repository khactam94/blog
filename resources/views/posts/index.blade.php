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
                    </div>
                </div>

                <div class="panel-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <table class="table table-hover">
                        <tbody>
                        @foreach ($posts as $key => $post)
                            <tr>
                            <td>
                                <h2><a href="{{ route('posts.show', ['id' => $post->id])}}">{{ $post->title }}</a></h2>
                                <div>{{ \Illuminate\Support\Str::words(strip_tags($post->content), 115, '...') }}</div>
                                <p>{{ $post->author }}
                                    <div class="category" style="display: inline-block;">
                                        <p style="float: left;"> 
                                            <i class="fa fa-user" aria-hidden="true"></i> By: <a href="#">{{ $post->user->name}}</a> | 
                                        </p>
                                        <p style="float: left;">
                                            &nbsp;<i class="fa fa-calendar" aria-hidden="true"></i> {{ $post->created_at->format('d/m/Y') }} | 
                                        </p>
                                        <p style="float: left;">
                                            &nbsp;<i class="fa fa-comments" aria-hidden="true"></i> <a href="#"> {{ $post->view }} viewer</a> | 
                                        </p>
                                        <p style="float: left;"> Categories: 
                                            @foreach($post->categories as $category)
                                            <span class="label label-primary">{{ $category->name }}</span> 
                                            @endforeach
                                        </p>
                                    </div>
                                </p>
                            </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $posts->appends(Request::only('q'))->render() }}
                </div>
            </div>
        </div>
    </div>
@endsection