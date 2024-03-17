<script>
    export default {
        data() {
            return {
                search: '',
                products: [],
                noProduct: false
            }
        },
        methods: {
            getProducts() {
                if(this.search.length > 2) {
                    axios
                        .get('/api/products?search=' + encodeURI(this.search))
                        .then( response => {
                            console.log(response);
                            if(response.data.data.length) {
                                this.products = response.data.data;
                                this.noProduct = false;
                            } else {
                                this.products = [];
                                this.noProduct = true;
                            }
                        })
                        .catch( error => {
                            console.log(error);
                        });
                } else {
                    this.products = [];
                    this.noProduct = false;
                }
            }
        },
        setup() {
            const search = '';
            return { search }
        },
    }
</script>

<template>
    <form action="#" @submit.prevent="getProducts()">
        <input type="text" v-model="search" v-on:keyup="getProducts()" class="form-control" placeholder="product name">
    </form>
    <ul>
        <li v-for="product in products" :key="product.id">{{product.name}}</li>
    </ul>
    <small v-if="products.length==0 && search.length>2">No products found</small>
</template>

<style lang="scss" scoped>
    ul {
        list-style: none;
        margin: 20px 0;
        padding: 0;
    }
</style>
