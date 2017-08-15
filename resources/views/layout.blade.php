<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"-->
    <link rel="stylesheet" type="text/css" href="/css/map/app.css">
    <script type="text/javascript" src="/js/map/app.js"></script>

    <title>Repair Directory</title>
</head>
<body>
<div>
    @yield('content')
    @include('footer')
</div>
</body>
</html>