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
    <section class="content-header">
        <h1>
            Categories
            <small>of posts</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><a href="#">Categories</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Create Category</h3>

                <div class="box-tools">
                    <a class="btn btn-success" href="{{ route('admin.categories.create') }}"> Add New</a>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                @include('flash::message')
                {!! Form::open(['route' => 'admin.categories.store']) !!}
                @include('admin.categories.fields')
                {!! Form::close() !!}
            </div>
            <!-- /.box-body -->
        </div>
    </section>
@endsection
