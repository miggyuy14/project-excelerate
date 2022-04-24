<template>
    <div class="px-5 pt-5 bg-white">
        <form @submit.prevent="submit">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Blotter</h5>
                <div class="form-row mb-3">
                    <div class="form-group">
                        <h5 for="Tower">Name</h5>
                        <p>{{ form.name }}</p>
                    </div>
                    <div class="form-group">
                        <h5 for="Title">Address</h5>
                            <p>{{ form.address }}</p>
                    </div>
                    <div class="form-group">
                        <h5 for="Title">Full Description</h5>
                            <p>{{ form.description }}</p>
                    </div>
                    <div class="form-group">
                        <h5 for="Title">logged by</h5>
                            <p>{{ form.creator.profile[0].full_name }}</p>
                    </div>
                </div>

                <!-- <div class="d-flex mt-3 mb-3 justify-content-end">
                            <button class="btn btn-lg btn-primary" type="submit" :disabled="loading['submit']">
                            <span v-if="!loading['submit']">Submit</span>
                            <span v-else><i class="fas fa-spinner fa-spin"></i> Submitting. ..</span>
                        </button>
                </div> -->

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
    props: ['id'],
    components: { Navbar },

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
                name: '',
                address: '',
                description: '',
                creator: '',
            },

            loading: {
                    submit: false,
                },

        };
    },

    created() {
        this.getDetails();
    },

    methods: {
        async getDetails() {
            const response = await axios.get(`/api/blotter/${this.id}`)
            this.form.name = response.data.name;
            this.form.address = response.data.address;
            this.form.description = response.data.description;
            this.form.creator = response.data.creator;
        }
    }
};
</script>
