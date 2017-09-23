@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading"><h1>Recently Post</h1></div>

                <div class="panel-body" style="padding-top: 0">
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
                    <center>{{ $posts->render() }}</center>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Categories</div>
                    @foreach($categories as $category)
                        <a href="{{ route('categories.show', ['id' => $category->id])}}" class="btn btn-primary">{{ $category->name }} ({{ $category->posts->count()}})</a> 
                    @endforeach
                <div class="panel-body">
                    
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Tags</div>
                    @foreach($tags as $tag)
                        <a href="{{ route('tags.show', ['id' => $tag->id])}}" class="btn btn-primary">{{ $tag->name }} ({{ $tag->posts->count()}})</a> 
                    @endforeach
                <div class="panel-body">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{asset('ckeditor/ckeditor.js')}}"></script>
@endsection
