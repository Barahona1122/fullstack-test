<template>
    <div>
        <!-- MESSAGE -->
        <div class="alert alert-primary " role="alert" id="success-message">
          {{message}}
        </div>

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col col-sm">
                        <h4>
                            Users
                        </h4>
                    </div>
                    <div class="col col-sm text-right">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#create_modal">Add</button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-responsive table-hover table-stipped" v-if="fill_users.length > 0">
                    <thead>
                        <tr>
                            <th width="300px">Name</th>
                            <th width="500px">Email</th>
                            <th width="300px"></th>
                            <th width="300px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in fill_users">
                            <td>{{user.name}}</td>
                            <td>{{user.email}}</td>
                            <td>
                                <a class="btn btn-primary text-white" @click="EditUser(user.id)" data-toggle="modal" data-target="#edit_modal">
                                    Edit
                                </a>
                            </td>

                            <td>
                                <button class="btn btn-danger" data-toggle="modal" data-target="#destroy_modal" @click="DestroyUser(user.id, user.name)">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div v-else>
                    <h3>Records was not Found!</h3>
                </div>
            </div>
        </div>

        <!-- MODALS -->
        <CreateModal :list_error="list_error"
                     :name="name"
                     :email="email"
                     :password="password"
                    @CreateUser="CreateUser">
        </CreateModal>

        <EditModal :name="name" :mail="email" :user_id="user_id" @UpdateUser="UpdateUser">
        </EditModal>


        <DestroyModal :user_id="user_id"
                    :name="name"
                    @ConfirmDestroyUser="ConfirmDestroyUser">
        </DestroyModal>
    </div>
</template>

<script>
    import CreateModal  from './modal/CreateModal';
    import EditModal    from './modal/EditModal';
    import DestroyModal from './modal/DestroyModal';

    export default {
        components:{
            CreateModal,
            EditModal,
            DestroyModal
        },
        data(){
            return{
                fill_users: [],
                list_error: [],
                name:       '',
                email:      '',
                password:   '',
                user_id:    '',
                message:    '',
            }
        },
        mounted() {
            this.fillUsers();
        },

        methods:{
            fillUsers(){
                let _this = this;
                axios.post('/admin/user/list')
                .then(function(response){
                    _this.fill_users = response.data;
                })
                .catch(function(error){
                    console.log(error);
                });
            },


            EditUser(user_id){
                let _this = this;
                axios.post("/admin/user/edit",{'id': user_id})
                .then(function(response){
                    _this.name    = response.data.name;
                    _this.email   = response.data.email;
                    _this.user_id = response.data.id;
                })
                .catch(function(error){
                    console.log(error.data);
                });
            },

            CreateUser(name, email, password){

                let _this = this;
                _this.AxiosRequest("/admin/user/store",{'name': name,
                                                'email': email,
                                                'password': password
                                                }
                                            ,"#create_modal"
                                            ,'#frmCreateElement');

            },

            UpdateUser(user_id, name, email, password){
                let _this = this;
                _this.AxiosRequest("/admin/user/update",{'id': user_id,
                                                'name': name,
                                                'email': email,
                                                'password': password
                                                }
                                            ,"#edit_modal"
                                            ,'#frmUpdateElement');
            },

            DestroyUser(user_id,name){
                let _this = this;
                _this.name    = name;
                _this.user_id = user_id;
            },

            ConfirmDestroyUser(user_id){
                let _this = this;
                _this.AxiosRequest("/admin/user/destroy",{'id': user_id},
                                                    "#destroy_modal"
                                                    ,""
                                                );
            },

            AxiosRequest(_url, data, modal, form){
                let _this = this;
                axios.post(_url, data)
                .then(function(response){
                    if(response.data.error == false){                        _this.message = response.data.message;
                        $('#success-message').fadeIn(2000);
                        $('#success-message').fadeOut(2000);
                        _this.fillUsers();
                        if(form != ''){
                            $(form)[0].reset();
                        }
                        $(modal).modal("hide");
                    }else{
                        _this.list_error = response.data.message;
                    }
                })
                .catch(function(error){
                    console.log(error.data);
                });
            },
        }
    }
</script>