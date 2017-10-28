<form method="POST" action="{{ route('admin.posts.destroy', $id) }}" accept-charset="UTF-8">
    <input name="_method" type="hidden" value="DELETE">
    {{ csrf_field() }}
    <div class="btn-group">
        <a href="{{ route("admin.posts.show", $id)}}" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-eye-open"></i></a>
        <a href="{{route('admin.posts.edit', $id)}}" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>
        <button type="submit" class="btn btn-danger btn-xs"
                  data-tr="tr_{{ $id }}"
                  data-toggle="confirmation"
                  data-btn-ok-label="Delete" data-btn-ok-icon="fa fa-remove"
                  data-btn-ok-class="btn btn-sm btn-danger"
                  data-btn-cancel-label="Cancel"
                  data-btn-cancel-icon="fa fa-chevron-circle-left"
                  data-btn-cancel-class="btn btn-sm btn-default"
                  data-title="Are you sure you want to delete ?"
                  data-placement="left" data-singleton="true"><i class="glyphicon glyphicon-trash"></i>
        </button>
    </div>
</form>