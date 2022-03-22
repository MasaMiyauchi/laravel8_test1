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
    <div class="p-3 m-3 bg-secondary">
        <div class="font-sans text-gray-900 antialiased ">
            corpNum_info page
        </div>
    </div>

<!--
    <div class="p-3 m-3 bg-primary">
    {{$search_corp_info_name}}<br \>
    {{$search_corp_info->corporateNumber}}<br \>
    </div>
-->

    <div id="testapp" class="p-3 m-3 bg-info">
        <h1>
        <span v-text="CompName"></span> （企業種別：<span v-text="CompKind"></span>）
    </h1>
        <span v-text="CompNum"></span><br />
        <span v-text="fullAddress"></span><br />
        <br />
        <h2>
        登録年月日
    </h2>
        <table>
            <tbody>
                <tr>
                    <td>
                        更新年月日：
                    </td>
                    <td>
                        <span v-text="CompUpdateDate"></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        変更年月日：
                    </td>
                    <td>
                        <span v-text="CompChangeDate"></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        法人番号指定年月日：
                    </td>
                    <td>
                        <span v-text="CompAssignmentDate"></span>
                    </td>
                </tr>
            </tbody>
        </table>
        </div>

    

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/vue@3.0.2/dist/vue.global.prod.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
    

    <script>
    Vue.createApp({
            data() {
                return {
                    CompName : '{{ $search_corp_info_name }}',
                    // JavaScript内にデータを埋め込む
                    CompNum : '{{ $search_corp_info->corporateNumber }}',
                    CompKind: '{{ $search_corp_kind }}',
                    CompPref:  '{{ $search_corp_info->prefectureName}}',
                    CompCity:  '{{ $search_corp_info->cityName}}',
                    CompStreet:  '{{ $search_corp_info->streetNumber}}',
                    CompAssignmentDate: '{{$search_corp_info->assignmentDate}}',
                    CompUpdateDate: '{{$search_corp_info->updateDate}}',
                    CompChangeDate: '{{$search_corp_info->changeDate}}',
                    check : 'hogehoge'
                }
            },
            computed:{
                fullAddress(){
                    return this.CompPref + this.CompCity + this.CompStreet
                }
            }
        }).mount('#testapp');
    </script>
</body>

</html>
