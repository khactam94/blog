@extends('admin.layouts.app')

@section('content')
<div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="pull-left" style="margin-left: 20px">
                            <h2>Tags List</h2>
                        </div>
                        <div class="pull-right" style="margin: 20px">
                            <a class="btn btn-success" href="{{ route('admin.tags.create') }}"> Add New</a>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    @include('admin.tags.table')
                </div>
            </div>
        </div>
    </div>   
@endsection

