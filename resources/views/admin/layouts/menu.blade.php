
@role('admin')
<li class="treeview {{ Request::is('admin/post*')}}">
    <a href="#">
        <i class="fa fa-users"></i>
        <span>Posts</span>
        <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
    </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('admin/posts') ? 'active' : '' }}">
            <a href="{{route('admin.posts.index')}}">All Posts</a></li>
        <li class="{{ Request::is('admin/status/draft') ? 'active' : '' }}">
            <a href="{{route('admin.posts.status', ['status' => 'draft'])}}">
                <i class="fa fa-hand-o-right"></i><span>Draft Posts</span></a>
        </li>
        <li class="{{ Request::is('admin/status/pending') ? 'active' : '' }}">
            <a href="{{route('admin.posts.status', ['status' => 'pending'])}}">
                <i class="fa fa-hand-o-right"></i><span>Pending Posts</span></a>
        </li>
        <li class="{{ Request::is('admin/status/approved') ? 'active' : '' }}">
            <a href="{{route('admin.posts.status', ['status' => 'approved'])}}">
                <i class="fa fa-hand-o-right"></i><span>Approved Posts</span></a>
        </li>
        <li class="{{ Request::is('admin/status/denied') ? 'active' : '' }}">
            <a href="{{route('admin.posts.status', ['status' => 'denied'])}}">
                <i class="fa fa-hand-o-right"></i><span>Denied Posts</span></a>
        </li>
    </ul>
</li>
@endrole
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