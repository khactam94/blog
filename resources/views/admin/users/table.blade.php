<table class="table table-responsive" id="users-table">
    <thead>
        <th>No.</th>
        <th>Name</th>
        <th>Email</th>
        <th>Password</th>
        <th>Roles</th>
        <th>Active</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{!! $loop->iteration !!}</td>
            <td>{!! $user->name !!}</td>
            <td>{!! $user->email !!}</td>
            <td>{!! $user->password !!}</td>
            <td>
                @if(!empty($user->roles))
                @foreach($user->roles as $v)
                    <label class="label label-success">{{ $v->display_name }}</label>
                @endforeach
                @endif
            </td>
            <td>{!! $user->active !!}</td>
            <td>
                {!! Form::open(['route' => ['admin.users.destroy', $user->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('admin.users.show', [$user->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('admin.users.edit', [$user->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>