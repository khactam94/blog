@extends('admin.layouts.app')

@section('css')
    <link href="{{ asset('ckeditor/plugins/codesnippet/lib/highlight/styles/default.css')}}" rel="stylesheet">
    <link href="{{ asset('ckeditor/custom.css')}}" rel="stylesheet">
    <script src="{{asset('ckeditor/plugins/codesnippet/lib/highlight/highlight.pack.js')}}"></script>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            Show Post
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Posts</a></li>
            <li class="active"><a href="#">Create New Post</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <div class="box-title" style="margin-left: 20px;">
                    <h1><b>{{$post->title}}</b></h1>
                    <div class="row" style="margin: 0px">
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
                <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id='posteditor' class="pull-left" style="padding: 0px 20px;">
                    {!! $post->content !!}
                </div>
                <script>hljs.initHighlightingOnLoad();</script>
            </div>
            <div class="box-footer">
                <div class="row" style="margin-left: 10px;">
                    <h3>Tags:</h3>
                    <p style="float: left">
                        @foreach($post->tags as $tag)
                            <span class="label label-primary">{{ $tag->name }}</span>
                        @endforeach
                    </p>
                </div>
                <div class="row" style="margin-left: 10px;">
                    <a class="btn btn-primary" href="{{ route('admin.posts.edit',$post->id) }}">Edit</a>
                    {!! Form::open(['method' => 'DELETE','route' => ['admin.posts.destroy', $post->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                    <a href="{!! route('admin.posts.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </section>
@endsection