<template>
    <div>
        <div class="alert alert-primary " role="alert" id="success-message">
          {{message}}
        </div>

        <div class="table table-responsive table-hover table-stipped" v-if="fill_products.length > 0">
            <thead>
                <tr>
                    <th width="400px">Product</th>
                    <th width="400px">Price</th>
                    <th width="400px">Quantity</th>
                    <th width="400px">Amount</th>
                    <th width="400px"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in fill_products">
                    <td>
                        {{product.product.name}}
                    </td>
                    <td>
                        {{product.product.price}}
                    </td>
                    <td>
                        <input type="number" :value="product.quantity" class="form-control" :id="'quantity_product_'+product.id" @blur="changeQuantity(product.id)">
                    </td>
                    <td>
                        {{product.total}}
                    </td>
                    <td>
                        <button class="btn btn-danger btn-sm" @click="DestroyProduct(product.id)">
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
            <div class="row p-2">
                <div class="col col-sm">
                    <a  href="/shop/checkout" class="btn btn-success">CheckOut</a>
                </div>
                <div class="col col-sm">
                    <h3>
                        Total: $ {{total}}    
                    </h3>
                    
                </div>
            </div>
        </div>
        <div v-else>
            <h2>No records was Found!</h2>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                fill_products: [],
                total: '',
                message: '',
            }
        },
        mounted() {
            this.fillProducts();
        },
        methods:{
            fillProducts(){
                let _this = this;
                axios.post('/shop/list/cart')
                .then(function(response){
                    _this.fill_products = response.data.carts;
                    _this.total         = response.data.total;
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

            changeQuantity(product_id){
                let _this = this;
                axios.post('/shop/changeQuantity',{'product_id':product_id,'quantity': $("#quantity_product_"+product_id).val()
                    })
                .then(function(response){
                    if(response.data.error == false){
                        _this.message = response.data.message;
                        $('#success-message').fadeIn(2000);
                        $('#success-message').fadeOut(2000);
                        _this.fillProducts();
                    }
                })
                .catch(function(error){
                    console.log(error);
                });
            },

            DestroyProduct(product_id){
                let _this = this;
                axios.post('/shop/DestroyCart',{'product_id':product_id
                    })
                .then(function(response){
                    if(response.data.error == false){
                        _this.message = response.data.message;
                        $('#success-message').fadeIn(2000);
                        $('#success-message').fadeOut(2000);
                        _this.fillProducts();
                    }
                })
                .catch(function(error){
                    console.log(error);
                });
            },
        }
    }
</script>