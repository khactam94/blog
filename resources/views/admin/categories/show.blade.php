@extends('admin.layouts.app')

@section('content')
     <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="pull-left" style="margin-left: 20px">
                            <h2>Categories</h2>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    @include('admin.categories.show_fields')
                    <a href="{!! route('categories.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
