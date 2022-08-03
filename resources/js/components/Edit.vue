<template>
    <div>
        <h3 class="text-center">Edit Product</h3>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form @submit.prevent="updateProduct">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="product.name">
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <img :src="product.picture" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>New Image</label>
                        <input type="file" class="form-control" @change="onFileSelected">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            selectedFile:null,
            errors:[],
            product: {}
        }
    },
    created() {
        this.axios
            .get(`http://127.0.0.1:8000/api/products/${this.$route.params.id}`)
            .then((res) => {
                this.product = res.data;
            });
    },
    methods: {
        updateProduct() {
            if (this.checkForm()) {
                const fd = new FormData();
                if (this.selectedFile) {
                    fd.append('image', this.selectedFile, this.selectedFile.name)
                }
                fd.append("_method", 'PATCH');
                fd.append('name', this.product.name)
                this.axios
                    .post(`http://127.0.0.1:8000/api/products/${this.$route.params.id}`, fd)
                    .then((res) => {
                        this.$router.push({name: 'home'});
                        this.$swal('Good job', 'Product updated succesfully', 'success')

                    });
            }
        },
        onFileSelected(event) {
            this.selectedFile = event.target.files[0]
        },
        checkForm(){
            this.errors=[]
            if(!this.product.name){
                console.log(this.product.name);
                this.errors.push("Name required.");
            }
            if (!this.errors.length) {
                return true;
            }
            else{
                console.log("ddd")
                console.log(this.errors)
                return false;
            }
        }
    }
}
</script>

<style scoped>
img{
    width: 200px;
    height: 200px;
}
</style>
