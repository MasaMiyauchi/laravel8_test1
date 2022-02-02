<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
<div id="app" class="container p-4">
    <h1 class="mb-5">法人情報・自動入力機能</h1>
    <div class="row mb-4">
        <div class="col-12">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#search_modal">法人情報を検索して自動入力する</button>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-4">
            <label>法人名</label>
            <input type="text" class="form-control" v-model="params.company_name">
        </div>
        <div class="col-4">
            <label>法人番号</label>
            <input type="text" class="form-control" v-model="params.company_id">
        </div>
        <div class="col-4">
            <label>所在地</label>
            <input type="text" class="form-control" v-model="params.company_address">
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="bg-light text-secondary p-3">
                <small>
                    <div class="mb-1 font-weight-bold">（APIの規約上、この表記が必要です）</div>
                    このサービスは、国税庁法人番号システムのWeb-API機能を利用して取得した情報をもとに作成していますが、サービスの内容は国税庁によって保証されたものではありません。
                </small>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="search_modal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="searchModalLabel">&#x1F50D; 法人情報を検索</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="input-group mb-3">
                                <input id="search_company_name" type="text" class="form-control" placeholder="例：株式会社Laravel" v-model="searchCompanyName" @keypress.enter="searchCompany">
                                <div class="input-group-append">
                                    <button class="btn btn-info" type="button" :disabled="searching" @click="searchCompany">検索する</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 p-1" v-if="searching">
                            &#x23F3; 検索中...
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" v-if="companies.length">
                            <div class="mb-2" style="max-height:350px;overflow-y:auto;">
                                <table class="table table-striped">
                                    <tbody>
                                        <tr v-for="c in companies">
                                            <td>
                                                <a href="#" @click.prevent="setCompany(c)">
                                                    @{{ c.name }}
                                                </a><br>
                                                <small class="text-secondary">@{{ c.id }}</small>
                                            </td>
                                            <td>
                                                <small class="text-secondary">
                                                    〒@{{ c.post_code }}<br>@{{ c.address }}
                                                </small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12 text-secondary" v-else>
                            会社データはありません。
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/vue@3.0.2/dist/vue.global.prod.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
<script>

    Vue.createApp({
        data(){
            return {
                params: {
                    company_name: '',
                    company_id: '',
                    company_address: ''
                },
                searchCompanyName: '',
                companies: [],
                searching: false
            }
        },
        methods: {
            searchCompany() {

                if(this.searching === false) {

                    this.searching = true;

                    const url = '/company_search';
                    const params = { company_name: this.searchCompanyName };
                    axios.post(url, params)
                        .then(response => {

                            this.companies = response.data;

                        })
                        .catch(error => {

                            console.log(error);

                        })
                        .finally(() => {

                            this.searching = false;

                        });

                }

            },
            setCompany(company) {

                this.params = {
                    company_name: company.name,
                    company_id: company.id,
                    company_address: company.address,
                };
                this.searchCompanyName = '';
                this.companies = [];
                $('#search_modal').modal('hide');

            }
        },
        mounted() {

            $('#search_modal').on('shown.bs.modal', () => {

                document.querySelector('#search_company_name').focus();

            });

        }
    }).mount('#app');

</script>
</body>
</html>