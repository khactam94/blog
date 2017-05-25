@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">Recently Post</div>

                <div class="panel-body">
                    <table class="table table-hover">
                        <tbody>
                        @foreach ($posts as $key => $post)
                            <tr>
                            <td>
                                <h2><a href="{{ route('posts.show', ['id' => $post->id])}}">{{ $post->title }}</a></h2>
                                <div>{{ \Illuminate\Support\Str::words(strip_tags($post->content), 115, '...') }}</div>
                                <p>{{ $post->author }}
                                    <div class="category">
                                        <p> Categories:
                                            @foreach($post->categories as $category)
                                            <span class="label label-primary">{{ $category->name }}</span>
                                            @endforeach
                                        </p>
                                    </div>
                                </p>
                            </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Categories</div>

                <div class="panel-body">
                    
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Tags</div>

                <div class="panel-body">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="{{asset('ckeditor/ckeditor.js')}}"></script>
@endsection
