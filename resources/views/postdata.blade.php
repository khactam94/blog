@foreach ($posts as $key => $post)
<tr>
    <td>
        <h2><a href="{{ route('posts.show', ['id' => $post->id])}}">{{ $post->title }}</a></h2>
        <div>{{ \Illuminate\Support\Str::words(strip_tags($post->content), 115, '...') }}</div>
        <p>{{ $post->author }}
            <span class="category" style="display: inline-block;">
        <p style="float: left;">
            <i class="fa fa-user" aria-hidden="true"></i> By: <a href="#">{{ $post->user->name}}</a> |
        </p>
        <p style="float: left;">
            &nbsp;<i class="fa fa-calendar" aria-hidden="true"></i> {{ $post->created_at->format('d/m/Y') }} |
        </p>
        <p style="float: left;">
            &nbsp;<i class="fa fa-comments" aria-hidden="true"></i> <a href="#"> {{ $post->view }} viewer</a> |
        </p>
        <p style="float: left;"> Categories:
            @foreach($post->categories as $category)
            <span class="label label-primary">{{ $category->name }}</span>
            @endforeach
        </p>
        </span>
        </p>
    </td>
</tr>
@endforeach