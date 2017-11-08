@extends('layouts.app')

@section('content')
<div class="container" style="width: 90%">
    <div class="row" style="padding-left: 50px">
        <div class="col-md-9" style="padding: 0">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>Recently Post</h1>
                </div>
                <div class="panel-body" style="padding: 0">
                    @include('flash::message')
                    <table class="table table-hover">
                        <tbody id="post-data">
                        @include('postdata')
                        </tbody>
                    </table>
                    <div class="ajax-load text-center">
                        <button class="btn btn-default" id="load-more">Load more</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">Categories</div>
                <div class="panel-body" style="padding: 10px">
                    @foreach($categories as $category)
                        <a href="{{ route('categories.show', ['id' => $category->id])}}" class="btn btn-primary">{{ $category->name }} ({{ $category->posts->count()}})</a>
                    @endforeach
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading" >Tags</div>
                <div class="panel-body" style="padding: 10px">
                    @foreach($tags as $tag)
                        <a href="{{ route('tags.show', ['id' => $tag->id])}}" class="btn btn-primary">{{ $tag->name }} ({{ $tag->posts->count()}})</a>
                    @endforeach
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

@section('scripts')
<script type="text/javascript">
    const max_page = {{$posts->lastPage()}};
    const loader_html = '<p><img src="{{ asset('images/loader.gif')}}">Loading More post</p>';
</script>
<script src="{{ asset('app/home.js') }}"></script>
@endsection
