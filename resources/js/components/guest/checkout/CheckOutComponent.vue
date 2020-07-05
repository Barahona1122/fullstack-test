<template>
    <div>
        <div class="row p-2">
            <GeneralData></GeneralData>
            <ProductsCard :fill_products="fill_products" :total="total">
            </ProductsCard>
        </div>
    </div>
</template>

<script>
    import GeneralData from './GeneralData.vue';
    import ProductsCard from './ProductsCard.vue';
    export default {
        components:{
            GeneralData,
            ProductsCard
        },
        data(){
            return{
                fill_products: [],
                total: '',
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

        }
    }
</script>
