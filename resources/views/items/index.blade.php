@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="pull-left" style="margin-left: 20px">
                            <h2>Item List</h2>
                        </div>
                        <div class="pull-right" style="margin: 20px">
                            <a class="btn btn-success" href="{{ route('items.create') }}">Add New</a>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    @include('items.table')
                </div>
            </div>
        </div>
    </div>
@endsection

