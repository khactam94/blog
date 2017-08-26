@extends('admin.layouts.app')

@section('css')
<style>
    .msg{
        margin: 5px;
        padding   : 5px;
    }
</style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="pull-left" style="margin-left: 20px">
                            <h2>Edit Category</h2>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                   {!! Form::model($category, ['route' => ['categories.update', $category->id], 'method' => 'patch']) !!}

                        @include('admin.categories.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection