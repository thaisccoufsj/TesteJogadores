<!doctype html>
<html>

<head>

    <script src="{{ asset('/js/jquery-3-6-0.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/jquery-ui.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('/js/jquery.mask.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('/js/moment-with-locales.js')}}" type="text/javascript"></script>
    <script src="{{ asset('/js/bootstrap-material-datetimepicker.js')}}" type="text/javascript"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/js/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/js/bootstrap-material-datetimepicker.css') }}">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <meta charset="utf-8">
    <title>Sorteio de Times</title>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-lg-8"> @yield('content') </div>
    </div>
</div>
</body>

</html>
