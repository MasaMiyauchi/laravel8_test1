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


    <div class="p-3 m-3">
        指定日に設立された企業情報
        <form action="{{ route('tgt_date_get') }}" method="post">
            @csrf
            <input name="date" type="date" />
            <input type="submit">
        </form>
    </div>


    <div class="p-3 m-3">
        企業番号の企業情報
        <form action="{{ route('compNo_comp_info') }}" method="post">
            @csrf
            <label for="compNo">企業番号</label><br>
            <input id="compNo" name="compNo" type="text" />
            <input type="submit">
        </form>
    </div>



    <div class="col-12">
        <div class="bg-white text-secondary p-3">
            <small>
                <div class="mb-1 font-weight-bold">（APIの規約上、この表記が必要です）</div>
                このサービスは、国税庁法人番号システムのWeb-API機能を利用して取得した情報をもとに作成していますが、サービスの内容は国税庁によって保証されたものではありません。
            </small>
        </div>
    </div>

</body>

</html>
