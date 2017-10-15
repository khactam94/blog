@extends('admin.layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('toastr/toastr.min.css') }}">
    <script src="{{ asset('toastr/toastr.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-confirmation/1.0.5/bootstrap-confirmation.min.js"></script>
@endsection

@section('content')
<div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="pull-left" style="margin-left: 20px">
                            <h2>Category List</h2>
                        </div>
                        <div class="pull-right" style="margin: 20px">
                            <a class="btn btn-success" href="{{ route('admin.categories.create') }}"> Add New</a>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    @include('flash::message')
                    @include('admin.categories.table')
                </div>
            </div>
        </div>
    </div>   
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('[data-toggle=confirmation]').confirmation({
                rootSelector: '[data-toggle=confirmation]',
                onConfirm: function (event, element) {
                    element.trigger('confirm');
                }
            });

            $(document).on('confirm', function (e) {
                e.preventDefault();
                $.ajax({
                    url: e.target.href,
                    type: 'DELETE',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (data) {
                        console.log(data);
                        if (data['success']) {
                            $("#" + data['data']['row']).slideUp("slow");
                            // Display a success toast, with a title
                            toastr.success(data['message'], 'Success');
                        } else if (data['error']) {
                            alert(data['error']);
                        } else {
                            alert('Whoops Something went wrong!!');
                        }
                    },
                    error: function (data) {
                        alert(data.responseText);
                    }
                });
                return false;
            });
        });
    </script>


@endsection

