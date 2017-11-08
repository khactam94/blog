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
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('app/app.css')}}">
    <!-- jQuery library -->
    <script src="{{ asset('vendor/jQuery/jquery-2.2.3.min.js')}}"></script>
    <!-- Latest compiled JavaScript -->
    <script src="{{ asset('vendor/bootstrap/bootstrap.min.js')}}"></script>
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
                        <li class="{{ Request::is('post*') ? 'active' : '' }}"><a href="{{route('posts.index')}}">Posts</a></li>
                        <li class="{{ Request::is('category*') ? 'active' : '' }}"><a href="{{route('categories.index')}}">Categories</a></li>
                        <li class="{{ Request::is('tag*') ? 'active' : '' }}"><a href="{{route('tags.index')}}">Tags</a></li>
                    </ul>
                    <div class="col-sm-3 col-md-3">
                        <form class="navbar-form" role="search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search" name="q" value="{{ Request::get('q')}}">
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

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{route('profiles.index')}}">Profile</a>
                                    </li>
                                    @if( Auth::user()->hasRole('admin'))
                                        <li>
                                            <a href="{{route('admin.posts.index')}}">All posts</a>
                                        </li>
                                    @endif
                                    <li>
                                        <a href="{{route('my_posts.index')}}">My posts</a>
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
    <footer class="main-footer">
        <div class="container">
        <strong>Copyright © 2014-2016 <a href="https://github.com/12t4bkdn/blog">Sample blog, sample laravel</a>.</strong>
            All rights reserved.
        </div>
    </footer>
    <script src="{{ asset('app/app.js')}}"></script>
    @yield('scripts')
</body>
</html>
