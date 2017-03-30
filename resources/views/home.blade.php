@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">Recently Post</div>

                <div class="panel-body">
                    
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Categories</div>

                <div class="panel-body">
                    
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Tags</div>

                <div class="panel-body">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="{{asset('ckeditor/ckeditor.js')}}"></script>
@endsection
