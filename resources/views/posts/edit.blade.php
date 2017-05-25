@extends('layouts.app')

@section('css')
    <link href="{{ asset('ckeditor/plugins/codesnippet/lib/highlight/styles/default.css')}}" rel="stylesheet">
   
    <script src="{{asset('ckeditor/ckeditor.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css"> 
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">

      <!-- JS Files -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.js"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><h2>Edit a post</h2></div>
                    <div class="panel-body">
                    	{!! Form::model($post, ['route' => ['posts.update', $post->id], 'method' => 'patch', 'files' => true]) !!}
                        @include('posts.fields')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function() {
    $('#categorytoken').tokenfield({
        autocomplete: {
        source: function (request, response) {
            jQuery.get("{{ route('categoryAjax')}}", {
                query: request.term
            }, function (data) {
                 data = $.parseJSON(data);
                /*var t = [];
                $.each(data,function(k,v){
                    t[k] = v.name;
                })*/
                response(data);
            });
        },
        delay: 100
        },
    showAutocompleteOnFocus: true
    });

    $('#tagtoken').tokenfield({
        autocomplete: {
        source: function (request, response) {
            jQuery.get("{{ route('tagAjax')}}", {
                query: request.term
            }, function (data) {
                data = $.parseJSON(data);
                /*var t = [];
                $.each(data,function(k,v){
                    t[k] = v.name;
                })*/
                response(data);
            });
        },
        delay: 100
        },
    showAutocompleteOnFocus: true
    });
});
</script>
@endsection
