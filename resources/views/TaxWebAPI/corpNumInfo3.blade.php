<!DOCTYPE html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <div id="app" class="container p-4">
        <div class="p-3 m-3">
            <div class="font-sans text-gray-900 antialiased">
                corpNum_info 3-1
            </div>
        </div>

        {{ $corp_info_name }}

        <span v-text="name"></span><br>
        <span v-text="check"></span>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script src="https://unpkg.com/vue@3.0.2/dist/vue.global.prod.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>

    </div>

    <script>
        Vue.createApp({
            data() {
                return {
                    name: '{{ $corp_info_name }}',
                    // JavaScript内にデータを埋め込む
                    check: 'hogehoge'
                }
            }
        }).mount('#app');
    </script>

</body>

</html>
