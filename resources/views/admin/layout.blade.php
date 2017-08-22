<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="/css/map/app.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
    <title>Repair Directory Admin</title>
</head>
<body>
<div class="container">
    <a href='/' class="header__link btn btn-primary">Home</a>
    <h1><a href="{{ route('admin.index') }}">Repair Directory Admin</a></h1>
    @yield('content')
    <script src="/js/map/admin.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
    @stack('scripts')
</div>
</body>
</html>