<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>

<body>
    <div class="p-3 m-3">
        <div class="font-sans text-gray-900 antialiased">
            TaxWebAPI
        </div>
        <button type="submit" form="get1" name="button1" value="test">
            get1
        </button>
        <form id="get1" action="{{ route('get1') }}" method="post">@csrf</form>
    </div>
    なんじゃ？？

    <div class="p-3 m-3">
        <form action="{{ route('get1') }}" method="post">
          @csrf
            Name: <input type="text" name="name"><br>
            <input type="submit">
        </form>
    </div>
</body>

</html>
