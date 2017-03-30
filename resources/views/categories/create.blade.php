@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><h2>Create a category</h2></div>
                    <div class="panel-body">
                    {!! Form::open(['route' => 'categories.store']) !!}

                        @include('categories.fields')

                    {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
