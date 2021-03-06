@extends('layouts.app')

@section('css')
    <link href="{{ asset('ckeditor/plugins/codesnippet/lib/highlight/styles/default.css')}}" rel="stylesheet">
    <link href="{{ asset('ckeditor/custom.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>{{$post->title}}</h2>
                    <div class="row" style="padding: 20px">
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
                </div>

                <div class="panel-body">
                    <div class="row">
                		<div id='posteditor' class="pull-left" style="padding: 20px">
                            {!! $post->content !!}
                        </div>
                    </div>
                    <hr>
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
    <script src="http://giaphiep.com/plugins/ckeditor/plugins/codesnippet/lib/highlight/highlight.pack.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
@endsection