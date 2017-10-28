<table class="table table-hover" id="categories-table">
    <thead>
        <th>No</th>
        <th>Name</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($categories as $category)
        <tr id = "cate_{{  $category->id }}">
            <td style="width: 10%">{{ $loop->iteration }}</td>
            <td>{{ $category->name }}</td>
            <td style="width: 20%">
                <div class='btn-group'>
                    <a href="{{ route('admin.categories.show', [$category->id]) }}" class='btn btn-default btn-sm'>Show</a>
                    <a href="{{ route('admin.categories.edit', [$category->id]) }}" class='btn btn-primary btn-sm'>Edit</a>
                    <a href="{{ route('api.categories.destroy', $category->id) }}" class="btn btn-danger btn-sm"
                       data-tr="tr_{{$category->id}}"
                       data-toggle="confirmation"
                       data-btn-ok-label="Delete" data-btn-ok-icon="fa fa-remove"
                       data-btn-ok-class="btn btn-sm btn-danger"
                       data-btn-cancel-label="Cancel"
                       data-btn-cancel-icon="fa fa-chevron-circle-left"
                       data-btn-cancel-class="btn btn-sm btn-default"
                       data-title="Are you sure you want to delete ?"
                       data-placement="left" data-singleton="true">
                        Delete
                    </a>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="text-center">{{ $categories->appends(Request::only('q'))->links()}}</div>
