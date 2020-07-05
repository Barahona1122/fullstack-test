<template>
    <div>
        <div class="row p-2 row justify-content-center">
            <div class="alert alert-primary " role="alert" id="success-message">
              {{message}}
            </div>

            <div class="col col-sm-6 text-center animate-box fadeInUp animated-fast">
                <div class="product">
                    <div class="product-grid" :style="'background-image:url('+url+');height: 250px;'">
                        <div class="inner" style="height: 250px;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-sm">
                            <h3>{{ name }}</h3>
                        </div>
                        <div class="col col-sm text-right">
                            <h5>
                                <span class="price badge badge-success text-white">
                                    $ {{ price}}
                                </span>
                            </h5>
                        </div>
                    </div>
                    <p>
                        {{description}}
                    </p>
                    <div class="row">
                        <div class="col col-sm">
                            <input type="number" v-model="quantity" class="form-control" placeholder="Quantity">
                        </div>
                        <div class="col col-sm">
                            <button class="btn btn-success btn-block" @click="addCart()">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        props:['slug'],
        data(){
            return{
                name: '',
                description: '',
                price:       '',
                product_id:  '',
                quantity:    '1',
                url:         '',
                message:     ''
            }
        },
        mounted() {
            this.fillProducts();
        },
        methods:{
            fillProducts(){
                let _this = this;
                axios.post('/shop/detail', {'slug': this.slug})
                .then(function(response){
                    _this.name        = response.data.name;
                    _this.description = response.data.description;
                    _this.price       = response.data.price;
                    _this.product_id  = response.data.id;
                    _this.url         = response.data.url
                })
                .catch(function(error){
                    console.log(error);
                });
            },

            addCart(){
                let _this = this;
                axios.post('/shop/addCart',{'product_id':this.product_id
                                            ,'quantity': this.quantity
                    }       )
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