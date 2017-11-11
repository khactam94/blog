@extends('layouts.app')

@section('content')
<div class="container" style="width: 90%">
    <div class="row" style="padding-left: 50px">
        <div class="col-md-9" style="padding: 0">
            <div class="panel panel-default">
                <div class="panel-heading" style="padding: 0;">
                    <ul class="nav nav-tabs nav-justified" style="font-size: 28px;">
                        <li class="{{ Request::is('posts*') ? 'active' : '' }}"><a href="{{route('posts.index')}}">Recently Posts</a></li></li>
                        <li class="{{ Request::is('post/hot') ? 'active' : '' }}"><a href="{{route('posts.hot')}}">Hot Posts</a></li></li>
                        <li class="{{ Request::is('post/popular') ? 'active' : '' }}"><a href="{{route('posts.popular')}}">Popular Posts</a></li></li>
                    </ul>

                </div>
                <div class="panel-body" style="padding: 0">
                    @include('flash::message')
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
                                </p>
                             </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <hr>
                    <div class="text-center">
                    {{ $posts->appends(Request::only('q'))->render() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading" >Donate</div>
                <div class="panel-body" style="padding: 10px">
                <a href="{{ route('donate') }}" class="btn btn-success">Donate</a>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" >Subcribe</div>
                <div class="panel-body" style="padding: 10px">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {!! Form::open(['route' => 'emails.subcribe', 'id' => 'subcribe_form']) !!}
                    <div class="input-group input-group-sm">
                        <input type="email" class="form-control" placeholder="Email" name='email'>
                        <span class="input-group-btn">
                              <button type="button" class="btn btn-info btn-flat" onclick="$('#subcribe_form').submit()">Submit</button>
                            </span>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
