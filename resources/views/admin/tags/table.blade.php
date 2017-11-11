<table class="table table-responsive" id="tags-table">
    <thead>
        <th>No</th>
        <th>Name</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($tags as $tag)
        <tr>
            <td width="10%">{!! $loop->iteration !!}</td>
            <td>{{ $tag->name }}</td>
            <td width="20%">
                {!! Form::open(['route' => ['admin.tags.destroy', $tag->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('admin.tags.show', [$tag->id]) !!}" class='btn btn-default btn-sm'>Show</a>
                    <a href="{!! route('admin.tags.edit', [$tag->id]) !!}" class='btn btn-primary btn-sm'>Edit</a>
                    {!! Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="text-center">{{ $tags->appends(Request::only('q'))->links()}}</div>