<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="/css/map/app.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
    <title>@lang('admin.title')</title>
</head>
<body>

    <header>
        <div class="container">
            <a href='/map' class="header__link btn btn-primary">@lang('admin.go_to_map')</a>
            <h1><a href="{{ route('admin.index') }}">@lang('admin.title')</a></h1>
        </div>
    </header>

    <main role="main">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer class="text-muted">
        <div class="container">
            <p>Created by the <a href="https://therestartproject.org">The Restart Project</a> and <a href="https://outlandish.com">Outlandish</a>.</p>
        </div>
    </footer>

    <script src="/js/map/admin.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
    @stack('scripts')
</body>
</html>
