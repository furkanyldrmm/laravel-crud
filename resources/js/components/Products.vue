<template>
    <div>
        <h2 class="text-center">Products List</h2>

        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Image</th>
                <th>CreatedAt</th>
                <th>Action</th>

                <!-- <th>Actions</th> -->
            </tr>
            </thead>
            <tbody>
            <tr v-for="product in products" :key="product.id">
                <td>{{ product.id }}</td>
                <td>{{ product.name }}</td>
                <td><img :src="product.picture"></td>
                <td>{{product.created_at}}</td>
                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'edit', params: { id: product.id }}" class="btn btn-success">Edit</router-link>
                        <button class="btn btn-danger" @click="deleteProduct(product.id)">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            products: []
        }
    },
    created() {
        this.axios
            .get('http://127.0.0.1:8000/api/products/')
            .then(response => {
                this.products = response.data;
                console.log(response.data,response.data.data)
            });
    },
    methods: {
        deleteProduct(id) {
            this.$swal({
                title: "Delete this product?",
                text: "Are you sure? You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Yes, Delete it!",
                closeOnConfirm: true
            }).then(()=>{
            this.axios
                .delete(`http://127.0.0.1:8000/api/products/${id}`)
                .then(response => {
                    let i = this.products.map(data => data.id).indexOf(id);
                    this.products.splice(i, 1)
                    this.$swal('Good job','Product deleted succesfully','success')

                });})
        }
    },
}
</script>
<style scoped>
img{
    height: 100px;
    width: 100px;
}
</style>
