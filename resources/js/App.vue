<script>
    export default {
        data() {
            return {
                search: '',
                products: [
                    { id: 1, name: 'sdaasdsadasd' },
                    { id: 2, name: 'xczvz' },
                    { id: 3, name: 'sdfsdf' },
                    { id: 4, name: 'asdasd' },
                    { id: 5, name: 'sdaasdzxczxc\sadasd' },
                ]
            }
        },
        methods: {
            getProducts() {
                console.log(this.search);
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
        <input type="text" v-model="search">
    </form>
    <ul>
        <li v-for="product in products" :key="product.id">{{product.name}}</li>
    </ul>
</template>

<style lang="scss" scoped>
    ul {
        list-style: none;
        margin: 20px 0;
        padding: 0;
    }
</style>
