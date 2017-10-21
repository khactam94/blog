@extends('layouts.app')

@section('content')
<div class="container" style="width: 90%">
    <div class="row" style="padding-left: 50px">
        <div class="col-md-9">

            <div class="panel panel-default">
                <div class="panel-heading"><h1>Recently Post</h1></div>
                <div class="panel-body" style="padding: 0">
                    <table class="table table-hover">
                        <tbody id="post-data">
                        @include('postdata')
                        </tbody>
                    </table>
                    <div class="ajax-load text-center" style="display:none">
                        <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading More post</p>
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
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">
        var page = 1;
        const max_page = {{$posts->lastPage()}};
        $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() >= $(document).height()) {
                if (page <max_page)
                {
                    page++;
                    loadMoreData(page);
                }
            }
        });

        function loadMoreData(page){
            $.ajax(
                {
                    url: '?page=' + page,
                    type: "get",
                    beforeSend: function()
                    {
                        $('.ajax-load').show();
                    }
                })
                .done(function(data)
                {
                    if(data.html == " "){
                        $('.ajax-load').html("No more records found");
                        return;
                    }
                    $('.ajax-load').hide();
                    console.log(data.html);
                    $("#post-data").append(data.html);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError)
                {
                    alert('server not responding...');
                });
        }
    </script>

@endsection
