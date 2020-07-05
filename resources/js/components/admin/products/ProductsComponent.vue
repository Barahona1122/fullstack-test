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
                            Products
                        </h4>
                    </div>
                    <div class="col col-sm text-right">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#create_modal">Add</button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-responsive table-hover table-stipped" v-if="fill_products.length > 0" id="divCont">
                    <thead>
                        <tr>
                            <th width="300px">Name</th>
                            <th width="500px">Description</th>
                            <th width="300px">Price</th>
                            <th width="300px">User</th>
                            <th width="300px">Status</th>
                            <th width="300px"></th>
                            <th width="300px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in fill_products">
                            <td>{{product.name}}</td>
                            <td>{{product.description.substring(0,30)+".."}}</td>
                            <td>{{product.price}}</td>
                            <td>{{product.user.name}}</td>
                            <td>
                                <p v-if="product.status = 1">
                                    <span class="badge badge-success">Active</span>
                                </p>
                                <p v-else>
                                    <span class="badge badge-danger">Inactive</span>
                                </p>
                            </td>
                            <td>
                                <a class="btn btn-primary text-white" @click="EditProduct(product.id)" data-toggle="modal" data-target="#edit_modal">
                                    Edit
                                </a>
                            </td>

                            <td>
                                <button class="btn btn-danger" data-toggle="modal" data-target="#destroy_modal" @click="DestroyProduct(product.id, product.name)">
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
                     :description="description"
                     :price="price"
                     :slug="slug"
                    @CreateProduct="CreateProduct">
        </CreateModal>

        <EditModal  :list_error="list_error"
                    :cover="cover"
                    :url="url"
                     :name="name"
                     :description="description"
                     :price="price"
                     :product_id="product_id"
                     :slug="slug"
                     @UpdateProduct="UpdateProduct">
        </EditModal>

        <DestroyModal :product_id="product_id" 
                    :name="name" 
                    @ConfirmDestroyProduct="ConfirmDestroyProduct">            
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
                fill_products: [],
                list_error:    [],
                name:          '',
                description:   '',
                price:         '',
                product_id:    '',
                slug:          '',
                cover:         '',
                url:           '',
                message:       '',
            }
        },
        mounted() {
            this.fillProducts();
        },

        methods:{
            fillProducts(){
                let _this = this;
                axios.post('/admin/product/list')
                .then(function(response){
                    _this.fill_products = response.data;
                })
                .catch(function(error){
                    console.log(error);
                });
            },


            EditProduct(product_id){
                let _this = this;
                axios.post("/admin/product/edit",{'id': product_id})
                .then(function(response){
                    if(response.data.error == false){
                        _this.name        = response.data.data.name;
                        _this.description = response.data.data.description;
                        _this.price       = response.data.data.price;
                        _this.product_id  = response.data.data.id;
                        _this.slug        = response.data.data.slug;
                        _this.url         = response.data.data.url;
                        _this.cover       = response.data.data.cover;
                    }
                })
                .catch(function(error){
                    console.log(error.data);
                });
            },

            CreateProduct(name, description, price, slug, product){
                let _this = this;

                var formData = new FormData();
                    formData.append("name", "name");
                    formData.append("description", description);
                    formData.append("price", price);
                    formData.append("slug", slug);
                    formData.append("product", product);
                    formData.append("cover", $("#cover")[0].files[0]);

                _this.AxiosRequest("/admin/product/store",formData
                                            ,"#create_modal"
                                            ,'#frmCreateElement');

            },

            UpdateProduct(product_id, name, description, price, slug){
                let _this = this;

                var formData = new FormData();
                    formData.append("name", "name");
                    formData.append("description", description);
                    formData.append("price", price);
                    formData.append("slug", slug);
                    formData.append("id", product_id);
                    formData.append("cover", $("#cover_change")[0].files[0]);

                _this.AxiosRequest("/admin/product/update",formData
                                            ,"#update_modal"
                                            ,'#frmUpdateElement');
            },

            DestroyProduct(product_id,name){
                let _this = this;
                _this.name       = name;
                _this.product_id = product_id;
            },

            ConfirmDestroyProduct(product_id){
                let _this = this;
                _this.AxiosRequest("/admin/product/destroy",{'id': product_id},
                                                    "#destroy_modal"
                                                    ,""
                                                );
            },

            AxiosRequest(_url, data, modal, form){
                let _this = this;
                axios.post(_url, data)
                .then(function(response){
                    if(response.data.error == false){
                        _this.message = response.data.message;
                        $('#success-message').fadeIn(2000);
                        $('#success-message').fadeOut(2000);
                        _this.fillProducts();
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