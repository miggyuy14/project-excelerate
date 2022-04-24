<template>
    <div class="px-5 pt-5 bg-white">
        <form @submit.prevent="submit">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">New Inevntory Item</h5>
                <div class="form-row mb-3">
                    <div class="form-group">
                        <h5 for="Tower">Name</h5>
                        <p>{{form.name}}</p>
                    </div>

                    <div class="form-group">
                        <h5 for="Title">Full Description</h5>
                           <p>{{ form.description }}</p>
                    </div>

                    <div class="form-group">
                        <h5 for="Tower">Quantity</h5>
                        <input type="number" class="container-fluid" v-model="form.quantity">
                    </div>
                    <!-- <div class="form-group col-4">
                        <h5 for="Country">Description</h5>
                            <v-select name="country" :options="country" label="name" v-model="form.countryHolder"></v-select> -->

                        <!-- <small v-if="isSubmitted && !$v.form.countryHolder.required" class="text-danger">Country is required</small> -->
                    <!-- </div> -->
                </div>

                <div class="d-flex mt-3 mb-3 justify-content-end">
                    <!-- <div v-if="!isUpserting">
                        <p>Created Date: {{writeOff.created_at}} By: {{writeOff.creator}}</p>
                        <p v-show="isClosed">Closed Date: {{writeOff.closed_at}} By: {{writeOff.closer}}</p>
                    </div> -->
                    <div>
                        <!-- <button v-if="isRequestor || isEditable" class="btn btn-primary" type="submit" :disabled="loading['submit']">
                            <span v-if="!loading['submit']">Update</span>
                            <span v-else><i class="fas fa-spinner fa-spin"></i> Updating...</span>
                        </button> -->

                        <!-- <button v-else-if="(isUpserting && this.levels.length > 0) || (isUpserting && isSmallDifferences && matrixLoaded)" class="btn btn-primary" type="submit" :disabled="loading['submit']"> -->
                            <button class="btn btn-lg btn-primary" type="submit" :disabled="loading['submit']">
                            <span v-if="!loading['submit']">Update</span>
                            <span v-else><i class="fas fa-spinner fa-spin"></i> Updating...</span>
                        </button>

                    </div>
                </div>

            </div>
        </div>
        </form>
    </div>
</template>
<script>
import Navbar from "@/Layouts/Navbar";
import axios from "axios";
// import { required } from 'vuelidate/lib/validators'

export default {
    components: { Navbar },
    props: ['id'],

    created() {
        this.getDetails();
    },

    data() {
        return {
            isSubmitted: false,
            customToolbar: [
                [{ 'font': [] }],
                [{ 'header': [false, 1, 2, 3, 4, 5, 6, ] }],
                ["bold", "italic", "underline"],
                [{ list: "ordered" }, { list: "bullet" }],
                ["image", "code-block", "table"]
            ],

            editorSettings: {
                modules: {
                imageDrop: true,
                imageResize: {},
                }
            },

            countries: [],
            departments: [],
            processes: [],
            towers: [],
            types: [],
            form: {
                id: this.id,
                name: '',
                description: '',
                quantity: '',
            },

            loading: {
                    submit: false,
                },

        };
    },

    methods: {
        async getDetails() {
            const response = await axios.get(`/api/inventory/${this.id}`);
            this.form.name = response.data.item_name;
            this.form.description = response.data.item_description;
            this.form.quantity = response.data.item_quantity;
        },
        submit() {
            try {
                this.isSubmitted = true;
                this.loading['submit'] = true;
                this.$inertia.put(route('inventory.update'), this.form, {
                    onSuccess: (page) => {
                        // this.$toast.success(this.$page.props.flash.success);
                        this.loading['submit'] = false;
                        this.$emit('close')
                    },
                })

            }catch (error) {

            }
        },

    }
};
</script>
