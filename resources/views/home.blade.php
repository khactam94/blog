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
                    <div class="ajax-load text-center" style="display:none">
                        <p><img src="{{ asset('images/loader.gif') }}">Loading More post</p>
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
        var page = 2;
        var isLoad = [];
        const max_page = {{$posts->lastPage()}};
        $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() >= $(document).height()) {
                if (!isLoad[page] && page <= max_page)
                {
                    loadMoreData(page);
                    page++;
                }
                else{
                    $('.ajax-load').show();
                    $('.ajax-load').html("No more records found");
                }
            }
        });

        function loadMoreData(page){
            var url = new URL(window.location.href);
            var q = url.searchParams.get("q");
            console.log(q);
            $.ajax(
                {
                    url: '?'+ (q ? 'q=' + q + '&' : '' ) + 'page=' + page,
                    type: "get",
                    async: false,
                    beforeSend: function()
                    {
                        $('.ajax-load').show();
                    }
                })
                .done(function(data)
                {
                    if(data.html == " "){
                        $('.ajax-load').html("No more records found");
                        return false;
                    }
                    $('.ajax-load').hide();
                    $("#post-data").append(data.html);
                    isLoad[page] = true;
                })
                .fail(function(jqXHR, ajaxOptions, thrownError)
                {
                    alert('server not responding...');
                });
            return false;
        }
    </script>

@endsection
