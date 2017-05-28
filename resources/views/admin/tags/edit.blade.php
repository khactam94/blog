@extends('admin.layouts.app')

@section('css')
   
@endsection

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
          <div class="panel panel-default">
              <div class="panel-heading"><h2>Edit a tag</h2></div>
              <div class="panel-body">
                <div class="row">
                    {!! Form::model($tag, ['route' => ['tags.update', $tag->id], 'method' => 'patch']) !!}
                        @include('admin.tags.fields')
                     {!! Form::close() !!}
                </div>
              </div>
          </div>
        </div>
    </div>
  </div>
@endsection

@section('scripts')

@endsection