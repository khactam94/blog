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
                            <h2>Create User</h2>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                   {!! Form::model($user, ['route' => ['admin.users.update', $user->id], 'method' => 'patch']) !!}

                        @include('admin.users.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection