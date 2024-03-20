<script>
    export default {
        data() {
            return {
                search: '',
                products: [],
                next: null,
                noProduct: false
            }
        },
        methods: {
            getProducts(url) {
                if(this.search.length > 2) {
                    axios
                        .get(url ? url : '/api/products?search=' + encodeURI(this.search))
                        .then( response => {
                            if(response.data.data.length) {
                                if(response.data.current_page>1) {
                                    this.products = this.products.concat(this.products, response.data.data);
                                } else {
                                    this.products = response.data.data;
                                }
                                this.next=response.data.next_page_url
                                this.noProduct = false;
                            } else {
                                this.products = [];
                                this.next = null;
                                this.noProduct = true;
                            }
                        })
                        .catch( error => {
                            console.log(error);
                        });
                } else {
                    this.products = [];
                    this.next = null;
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
    <form action="#" @submit.prevent="getProducts(null)">
        <input type="text" v-model="search" v-on:keyup="getProducts()" class="form-control" placeholder="product name">
    </form>
    <ul>
        <li v-for="product in products" :key="product.id">
            <a :href="product.url" target="_blank" v-html="product.name"></a>
        </li>
    </ul>
    <div class="text-center">
        <small v-if="products.length==0 && search.length>2">No products found</small>
        <a href="#" v-show="next" @click="getProducts(next)">next</a>
    </div>
</template>


<style lang="scss">
    a {
        text-decoration: none;
        color: black;
    }
    ul {
        list-style: none;
        margin: 20px 10px;
        padding: 0;
        li {
            a {
                &:hover {
                    color: blue;
                }
                span {
                    color: red;
                }
            }
        }
    }
</style>
