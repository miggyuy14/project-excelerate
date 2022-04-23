<template>
    <div class="px-5 pt-5 bg-white">
        <form @submit.prevent="submit">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">New Leader</h5>
                <div class="form-row mb-3">
                    <div class="form-group">
                        <h5 for="Tower">Zone</h5>
                        <v-select name="Types" :options="zones"  label="name" v-model="form.zone"></v-select>
                    </div>
                    <div class="form-group">
                        <h5 for="Title">Name</h5>
                            <v-select name="Types" :options="residents"  :get-option-label="(option) => option.profile.full_name" v-model="form.name"></v-select>
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

    created() {
        this.getZones();
        this.getResidents();
    },

    data() {
        return {
            isSubmitted: false,
            zones: [],
            residents: [],
            names: [],
            form: {
                name: '',
                zone: '',
            },

            loading: {
                    submit: false,
                },

        };
    },

    methods: {
        async getZones(){
            const response = await axios.get('/api/zones');
            this.zones = response.data;
            console.log(this.zones);
        },

        async getResidents(){
            const response = await axios.get('/api/leader');
            this.residents = response.data;
            console.log(this.residents);
        },

        submit() {
            this.$swal({
                title: 'Are you sure?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                showCloseButton: true,
                showLoaderOnConfirm: true
                }).then((result) => {
                if(result.value) {
                    this.$inertia.put(`/admin/user/leader/${this.form.name.id}`)
                    this.$swal('Approved', 'You successfully added a leader', 'success');
                    this.$emit('close');
                } else {
                    this.$swal('Cancelled', "Nothing happened", 'info')
                }
                });
        },
    }
};
</script>
