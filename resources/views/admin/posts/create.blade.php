@extends('admin.layouts.app')

@section('css')
    <link href="{{ asset('ckeditor/plugins/codesnippet/lib/highlight/styles/default.css')}}" rel="stylesheet">
    <script src="{{asset('ckeditor/ckeditor.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css"> 
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">
    <link href="{{ asset('vendor/toastr/toastr.css') }}" rel="stylesheet"/>
    <!-- JS Files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.js"></script>
@endsection
@section('content')
    <section class="content-header">
        <h1>
            New Post
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Posts</a></li>
            <li class="active"><a href="#">Create New Post</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Create New Post</h3>
                <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                {!! Form::open(['route' => 'admin.posts.store']) !!}
                @include('admin.posts.fields')
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
<script type="text/javascript">
    const addTagUrl = "{{ route('api.tags.store') }}";
    const categoryAjaxUrl = "{{ route('categoryAjax') }}";
    const tagAjaxUrl = "{{ route('tagAjax') }}";
</script>
<script src="{{ asset('app/admin/posts/create.js') }}"></script>
@endsection
