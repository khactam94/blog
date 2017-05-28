@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="pull-left" style="margin-left: 20px">
                            <h2>Category List</h2>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    @include('categories.table')
                </div>
            </div>
        </div>
    </div>   
@endsection

