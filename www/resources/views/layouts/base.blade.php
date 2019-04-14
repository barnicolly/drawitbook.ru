<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    {!! $metadata !!}
    <link rel="icon" href="favicon.ico">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{  asset('build/css/master.min.css') }}">
</head>
<body>
{!! $content !!}
<script src="{{ asset('build/js/master.min.js') }}" defer></script>
</body>
</html>