<script>
    export default {
        data() {
            return {
                search: '',
                products: [],
                next: null,
                noProduct: false,
                history
            }
        },
        methods: {
            getProducts(url) {
                if(this.search.length > 2) {
                    axios
                        .get(url ? url : '/api/getProducts?search=' + encodeURI(this.search))
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
            },
            addToHistory() {
                if(this.search.length > 2) {
                    axios
                        .post('/api/addToHistory', {
                            cookie: this.cookie,
                            search: this.search,
                        })
                        .then( response => {
                            console.log(response);
                        })
                        .catch( error => {
                            console.log(error);
                        });
                    this.getHistory();
                }
            },
            getHistory() {
                axios
                    .get('/api/getHistory?cookie=' + this.cookie)
                    .then( response => {
                        this.history = response.data;
                    })
                    .catch( error => {
                        console.log(error);
                    });
            },
            useHistory(event) {
                this.search = event.target.value;
                this.getProducts();
                document.getElementById("history").value = 0;
            },
        },
        computed: {
            cookie() {
                let cookieName = 'id';
                let value = document.cookie.match('(^|;)?' + cookieName + '=([^;]*)(;|$)');
                if(!value) {
                    document.cookie = cookieName + '=' + Math.floor(Math.random() * 9999999999);
                    value = document.cookie.match('(^|;)?' + cookieName + '=([^;]*)(;|$)');
                }
                return value[2];
            },
        },
        beforeMount() {
            this.getHistory();
        },
    }
</script>


<template>
    <form action="#" @submit.prevent="getProducts(null)">
        <div class="row">
            <div class="col-md-6 mt-md-1">
                <label>Product search</label>
                <input type="text" id="search" v-model="search" @keyup="getProducts()" @blur="addToHistory()" class="form-control" placeholder="product name">
            </div>
            <div class="col-md-6 mt-3 mt-md-1">
                <label>Search history</label>
                <select id="history" class="form-control" @change="useHistory($event)">
                    <option v-for="item in history">{{ item.search }}</option>
                </select>
            </div>
        </div>
    </form>
    <ul>
        <li v-for="product in products" :key="product.id">
            <a :href="product.url" target="_blank" v-html="product.name"></a>
        </li>
    </ul>
    <div class="text-center">
        <small v-if="products.length==0 && search.length>2">No products found</small>
        <a v-show="next" @click="getProducts(next)" class="next">next</a>
    </div>
</template>


<style lang="scss">
    a {
        text-decoration: none;
        color: black;
        &:hover {
            cursor: pointer;
        }
    }
    ul {
        list-style: none;
        margin: 30px 0px;
        padding: 0;
        li {
            width: 100%;
            padding: 0.25em 1em;
            &:hover {
                background-color: #EEEEEE;
            }
            a {
                span {
                    color: red;
                }
            }
        }
    }
    a.next {
        &:hover {
            font-weight: bold;
        }
    }
</style>
