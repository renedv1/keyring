<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title')</title>
        {{ HTML::style('packages/bootstrap/css/bootstrap.min.css') }}
        {{ HTML::style('assets/css/style.css')}}
    </head>
    <body>

        <div class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <ul class="nav navbar-nav"> 
                        <li>{{ HTML::link('/', 'Home') }}</li>
                        @if(!Auth::check())
                        <li>{{ HTML::link('account/login', 'Login') }}</li>  
                        @else
                        <li>{{ HTML::link('keyring', 'My Keys') }}</li>
                        <li>{{ HTML::link('account/logout', 'Logout') }}</li>
                        @endif
                    </ul>  
                </div>
            </div>
        </div>

        <div class="container-fluid" id="logo">
            <div>
                @yield('page_top')
            </div>

            @if(Session::has('alert-success'))
            <div class="alert alert-success">
                {{Session::get('alert-success')}}
            </div>
            @endif

            @if(Session::has('alert-danger'))
            <div class="alert alert-danger">
                {{Session::get('alert-danger')}}
            </div>
            @endif
        </div>

        <div class="container-fluid">
            <div>
                @yield('content')
            </div>
        </div>

    </body>
    {{ HTML::script('packages/jquery/jquery.js') }}
    {{ HTML::script('packages/bootstrap/js/bootstrap.js') }}
    {{ HTML::script('assets/js/keyring.js') }}
</html>
