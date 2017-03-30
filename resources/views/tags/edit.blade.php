@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Tag
        </h1>
   </section>
   <div class="content">
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($tag, ['route' => ['tags.update', $tag->id], 'method' => 'patch']) !!}

                        @include('tags.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection