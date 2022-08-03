<template>
    <div>
        <h3 class="text-center">Create Product</h3>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="text-danger" v-if="errors.length">
                    <b>Please correct the following error(s):</b>
                    <ul>
                        <li v-for="error in errors">{{ error }}</li>
                    </ul>
                </div>
                <form @submit.prevent="addProduct">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="name">
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" class="form-control" @change="onFileSelected">
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            errors: [],
            name: null,
            selectedFile: null
        }
    },
    methods: {
        addProduct() {
            if(this.checkForm()){
            const fd = new FormData();
            fd.append('image', this.selectedFile, this.selectedFile.name)
            fd.append('name', this.name)

            this.axios
                .post('http://127.0.0.1:8000/api/products', fd)
                .then(response => (
                    this.$router.push({name: 'home'}),
                        this.$swal('Good job', 'Product added succesfully', 'success')
                ))
                .catch(err => console.log(err))
                .finally(() => this.loading = false)
        }
        },
        onFileSelected(event) {
            this.selectedFile = event.target.files[0]
        },
        checkForm() {
            this.errors=[]
            if (!this.name) {
                this.errors.push("Name required.");
            }
            if (!this.selectedFile) {
                this.errors.push('Image required.');
            }
            if (!this.errors.length) {
                return true;
            }
            else{
                console.log(this.errors)
                return false;
            }
        }
    }
}
</script>
