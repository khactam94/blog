<table class="table table-responsive" id="categories-table">
    <thead>
        <th>Name</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($categories as $category)
        <tr>
            <td>{!! $category->name !!}</td>
            <td>
                {!! Form::open(['route' => ['categories.destroy', $category->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('categories.show', [$category->id]) !!}" class='btn btn-default'>Show</a>
                    <a href="{!! route('categories.edit', [$category->id]) !!}" class='btn btn-primary'>Edit</a>
                    {!! Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<center>{{ $categories->links()}}</center>