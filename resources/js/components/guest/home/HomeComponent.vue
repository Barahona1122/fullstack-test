<template>
    <div>
        <div class="alert alert-primary " role="alert" id="success-message">
          {{message}}
        </div>

        <div class="row">
            <div class="col-sm-6 col-md-5 col-lg-4 text-center animate-box fadeInUp animated-fast cardProduct" v-for="product in fill_products">
                <div class="product">
                    <div class="product-grid" :style="'background-image:url('+product.url+');height: 250px;'">
                    </div>
                    <div class="desc">
                        <div class="row">
                            <div class="col col-sm">
                                <h5>
                                    <a :href="'/shop/product/'+product.slug">
                                        See details
                                    </a>
                                </h5>
                            </div>
                            <div class="col col-sm text-right">
                                <h5>
                                    <span class="price badge badge-success text-white">    $ {{ product.price}}
                                    </span>
                                </h5>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col col-sm">
                                <input type="number" class="form-control" :id="'quantity_product_'+product.id" :value="1">
                            </div>
                            <div class="col col-sm">
                                <button class="btn btn-success btn-block" @click="addCart(product.id)">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data(){
            return{
                fill_products: [],
                message: '',
            }
        },
        mounted() {
            this.fillProducts();
        },
        methods:{
            fillProducts(){
                let _this = this;
                axios.post('/shop/products')
                .then(function(response){
                    _this.fill_products = response.data;
                })
                .catch(function(error){
                    console.log(error);
                });
            },

            addCart(product_id){
                let _this = this;
                axios.post('/shop/addCart',{'product_id':product_id,'quantity': $("#quantity_product_"+product_id).val()
                    })
                .then(function(response){
                    if(response.data.error == false){
                        _this.message = response.data.message;
                        $('#success-message').fadeIn(2000);
                        $('#success-message').fadeOut(2000);
                    }
                })
                .catch(function(error){
                    console.log(error);
                });
            },
        }
    }
</script>