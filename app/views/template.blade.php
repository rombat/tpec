<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    {{ HTML::style(asset('/css/bootstrap.min.css')) }}
    {{ HTML::style(asset('/css/font-awesome.min.css')) }}
    {{ HTML::style(asset('/css/perso.css')) }}
    @yield('styles_additionnels')
</head>

<body>
@include('master.navbar')

<div class="container">
    <div class="row">
        <div class="col-md-12">

            @if (Session::has('message'))
                <div class="flash alert">
                    <p>{{ Session::get('message') }}</p>
                </div>
            @endif

            @yield('main')

        </div>
    </div>
</div>

{{ HTML::script(asset('/js/jquery.js')) }}
{{ HTML::script(asset('/js/bootstrap.min.js')) }}
@yield('scripts_additionnels')
</body>
</html>