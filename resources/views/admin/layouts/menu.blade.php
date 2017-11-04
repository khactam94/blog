<li class="{{ Request::is('admin/posts*') ? 'active' : '' }}"><a href="{{route('admin.posts.index')}}">Posts</a></li>
<li class="{{ Request::is('admin/categories*') ? 'active' : '' }}"><a href="{{route('admin.categories.index')}}">Categories</a></li>
<li class="{{ Request::is('admin/tags*') ? 'active' : '' }}"><a href="{{route('admin.tags.index')}}">Tags</a></li>
<li class="{{ Request::is('admin/statistics*') ? 'active' : '' }}"><a href="{{route('admin.statistics.index')}}">Statistics</a></li>
@role('admin')
<li class="treeview {{ Request::is('admin/users*') || Request::is('admin/permissions*') || Request::is('admin/roles*')? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-users"></i>
        <span>User, Role, Permission</span>
        <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
    </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('admin/users*') ? 'active' : '' }}">
            <a href="{{ route('admin.users.index') }}"><i class="fa  fa-user"></i><span>Users</span></a>
        </li>
        <li class="{{ Request::is('admin/permissions*') ? 'active' : '' }}">
            <a href="{!! route('admin.permissions.index') !!}"><i class="fa fa-hand-o-right"></i><span>Permissions</span></a>
        </li>

        <li class="{{ Request::is('admin/roles*') ? 'active' : '' }}">
            <a href="{!! route('admin.roles.index') !!}"><i class="fa fa-hand-o-right"></i><span>Roles</span></a>
        </li>
    </ul>
</li>
@endrole