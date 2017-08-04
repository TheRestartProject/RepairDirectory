<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <title>Repair Directory Admin</title>
</head>
<body>
<div class="container">
    <h1><a href="{{ route('admin.index') }}">Repair Directory Admin</a></h1>
    @yield('content')
</div>
</body>
</html>