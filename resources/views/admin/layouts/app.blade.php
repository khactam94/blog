<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css')}}">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    <!-- jQuery library -->
    <script src="{{ asset('js/jquery.min.js')}}"></script>

    <!-- Latest compiled JavaScript -->
    <script src="{{ asset('js/bootstrap.min.js')}}"></script>
    @yield('css')
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li class="{{ Request::is('admin/posts*') ? 'active' : '' }}"><a href="{{route('admin.posts.index')}}">Posts</a></li>
                        <li class="{{ Request::is('admin/categories*') ? 'active' : '' }}"><a href="{{route('admin.categories.index')}}">Categories</a></li>
                        <li class="{{ Request::is('admin/tags*') ? 'active' : '' }}"><a href="{{route('admin.tags.index')}}">Tags</a></li>
                        <li class="dropdown {{ Request::is('admin/users*') || Request::is('admin/roles*') || Request::is('admin/permissions*') ? 'active' : '' }}">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Accounts <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                              <li class="{{ Request::is('admin/users*') ? 'active' : '' }}"><a href="{{route('admin.users.index')}}">Users</a></li>
                              <li class="{{ Request::is('admin/roles*') ? 'active' : '' }}"><a href="{{route('admin.roles.index')}}">Roles</a></li>
                              <li class="{{ Request::is('admin/permissions*') ? 'active' : '' }}"><a href="{{route('admin.permissions.index')}}">Permissions</a></li>
                            </ul>
                        </li>
                    </ul>
                    <div class="col-sm-3 col-md-3">
                        <form class="navbar-form" role="search" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search" name="q">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                <!-- <i class="glyphicon glyphicon-search"></i> -->
                                <i class="fa fa-search" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                @if( Auth::user()->hasRole('admin'))
                                
                                @endif
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('my_posts.index') }}">
                                            My posts
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>
    @yield('scripts')
</body>
</html>
