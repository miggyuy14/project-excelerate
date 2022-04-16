<template>
    <div class="px-5 pt-5 bg-white">
        <form @submit.prevent="submit">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">New Blotter </h5>
                <div class="form-row mb-3">
                    <div class="form-group">
                        <h5 for="Tower">Name</h5>
                        <input type="text" class="container-fluid" v-model="form.name">
                    </div>
                    <div class="form-group">
                        <h5 for="Title">Address</h5>
                            <textarea class="container-fluid" v-model="form.address" type="text"></textarea>
                    </div>
                    <div class="form-group">
                        <h5 for="Title">Full Description</h5>
                            <textarea class="container-fluid" v-model="form.description" type="text"></textarea>
                    </div>
                </div>

                <div class="d-flex mt-3 mb-3 justify-content-end">
                            <button class="btn btn-lg btn-primary" type="submit" :disabled="loading['submit']">
                            <span v-if="!loading['submit']">Submit</span>
                            <span v-else><i class="fas fa-spinner fa-spin"></i> Submitting. ..</span>
                        </button>
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

    data() {
        return {
            isSubmitted: false,
            form: {
                name: '',
                address: '',
                description: '',
            },

            loading: {
                    submit: false,
                },

        };
    },

    methods: {
        submit() {
            try {
                this.isSubmitted = true;
                this.loading['submit'] = true;
                this.$inertia.post(route('admin.blotter.store'), this.form, {
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
