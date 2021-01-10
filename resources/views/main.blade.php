<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/app.css">
</head>
<body>
<div id="app">
    {{--<div class="container">--}}
        {{--<App></App>--}}
    {{--</div>--}}
    <div class="container">
        <Upload></Upload>
    </div>
    <div class="container">
        <Torrent></Torrent>
    </div>
</div>
<script src="{{ mix('js/vue_learn.js') }}"></script>
</body>
</html>
