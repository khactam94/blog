@extends('layouts.app')

@section('css')
    <link href="{{ asset('ckeditor/plugins/codesnippet/lib/highlight/styles/default.css')}}" rel="stylesheet">
    <script src="{{asset('ckeditor/plugins/codesnippet/lib/highlight/highlight.pack.js')}}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                <div class="row">
                        <div class="pull-left" style="margin-left: 20px">
                            <h2>Post</h2>
                        </div>
                        <div class="pull-right" style="margin: 20px">
                            <a class="btn btn-success" href="{{ route('posts.index') }}"> Back</a>
                        </div>
                    </div>
                    <hr>
                    <h2>{{$post->title}}</h2>
                    <div class="row" style="padding: 20px">
                        <p>View: {{$post->view}}; Author: {{$post->user->name}}; Date: {{$post->created_at}}</p>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="row">
                		<div id='posteditor' class="pull-left" style="padding: 50px">
                            {!! $post->content !!}
                        </div>
                        <script>hljs.initHighlightingOnLoad();</script>
                    </div>
                    <div class="row" style="margin-left: 10px;">
                        <div class="category">
                            <h3>Categories:</h3> 
                            <p>
                                @foreach($post->categories as $category)
                                <span class="label label-primary">{{ $category->name }}</span>
                                @endforeach
                            </p>
                        </div>
                    </div>
                    <div class="row" style="margin-left: 10px;">
                        <div class="tag">
                            <h3>Tags:</h3> 
                            <p>
                                @foreach($post->tags as $tag)
                                <span class="label label-primary">{{ $tag->name }}</span>
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection