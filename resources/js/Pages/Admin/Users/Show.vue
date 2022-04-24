
<template>
    <div class="px-5 pt-5 bg-white">
        <form @submit.prevent="submit">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ currentTabComponent }} Info </h5>
                <div class="form-row mb-3">
                    <div class="form-group">
                        <h5 for="Tower">Name</h5>
                        <p>{{ data.profile.full_name }}</p>
                    </div>
                    <div class="form-group">
                        <h5 for="Title">Address</h5>
                            <p>{{ data.profile.address }}</p>
                    </div>
                    <div class="form-group">
                        <h5 for="Title">Gender</h5>
                            <p>{{ data.profile.gender }}</p>
                    </div>
                    <div class="form-group">
                        <h5 for="Title">Birthday</h5>
                            <p>{{ data.profile.birthday | formatDate }}</p>
                    </div>
                    <div class="form-group">
                        <h5 for="Title">Marital Status</h5>
                            <p>{{ data.profile.marital_status }}</p>
                    </div>
                    <div class="form-group">
                        <h5 for="Title">Nationality</h5>
                            <p>{{ data.profile.nationality }}</p>
                    </div>
                    <div class="form-group">
                        <h5 for="Title">Religion</h5>
                            <p>{{ data.profile.religion }}</p>
                    </div>
                    <div class="form-group">
                        <h5 for="Title">Household count</h5>
                            <p>{{ data.profile.household_count }}</p>
                    </div>
                </div>
                <div class="form-row mb-3">
                <div class="form-group col-4">
                        <h5 for="Team">Occupation</h5>
                            <p>{{ data.profile.occupation }}</p>
                    </div>
                    <div class="form-group col-4">
                        <h5 for="Team">Zone</h5>
                            <p>Zone {{ data.profile.zone_id }}</p>
                    </div>
                </div>


                <div class="form-row mb-3">
                <h5>Vaccine Information</h5>
                <div class="form-group col-4">
                        <h5 for="Team">First Dose Date</h5>
                            <p>{{ data.profile.first_dose | formatDate }}</p>
                    </div>
                    <div class="form-group col-4">
                        <h5 for="Team">Second Dose Date</h5>
                            <p>{{ data.profile.second_dose | formatDate }}</p>
                    </div>
                    <div class="form-group col-4">
                        <h5 for="Team">Booster Date</h5>
                            <p>{{ data.profile.booster | formatDate }}</p>
                    </div>
                    <div class="form-group col-4">
                        <h5 for="Team">Booster Count</h5>
                            <p>{{ data.profile.booster_count }}</p>
                    </div>
                </div>

                <div class="d-flex mt-3 mb-3 justify-content-end">
                        <button class="btn btn-success" v-if="data.profile.first_dose == null && isClinic" @click="first_dose()" :disabled="loading['submit']">
                            <span v-if="!loading['submit']">Add first dose</span>
                            <span v-else><i class="fas fa-spinner fa-spin"></i> Submitting. ..</span>
                        </button>

                        <button class="btn btn-success" v-if="data.profile.first_dose != null && data.profile.second_dose == null && isClinic" @click="second_dose()" :disabled="loading['submit']">
                            <span v-if="!loading['submit']">Add second dose</span>
                            <span v-else><i class="fas fa-spinner fa-spin"></i> Submitting. ..</span>
                        </button>

                        <button class="btn btn-success" v-if="data.profile.second_dose != null && isClinic" @click="booster()" :disabled="loading['submit']">
                            <span v-if="!loading['submit']">Add booster</span>
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
    props: ['id'],
    components: { Navbar },

    created() {
        this.getResident();
    },

    computed: {
            isClinic() {
            if(this.$page.props.auth.roles.includes('doctor') || this.$page.props.auth.roles.includes('nurse')){
                return true;
            }else{
                return false;
            }
        },
    },

    data() {
        return {
            currentTabComponent: new URL(location.href).searchParams.get('tab'),
            isSubmitted: false,
            data: '',

            loading: {
                    submit: false,
                },

        };
    },

    methods: {
        async getResident() {
            const response = await axios.get(`/api/resident/${this.id}`);
            this.data = response.data;
            console.log(this.data);
        },
        store() {
            this.store();
        },
        submit() {
            try {
                this.isSubmitted = true;
                this.loading['submit'] = true;
                this.$inertia.post(route('ticket.store'), this.form, {
                    onSuccess: (page) => {
                        this.$toast.success(this.$page.props.flash.success);
                        this.loading['submit'] = false;
                        this.$emit('close')
                    },
                })

            }catch (error) {

            }
        },

        first_dose() {
            this.$swal({
                title: 'Is the vaccination confirmed?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                showCloseButton: true,
                showLoaderOnConfirm: true
                }).then((result) => {
                if(result.value) {
                    this.$inertia.put(`/clinic/consultation/vaccine/first/${this.id}`)
                    this.$swal('Approved', 'Vaccination confirmed!', 'success')
                    this.$emit('close');
                } else {
                    this.$swal('Cancelled', "Nothing happened", 'info')
                    this.$emit('close');
                }
            });
        },

        second_dose(){
            this.$swal({
                title: 'Is the vaccination confirmed?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                showCloseButton: true,
                showLoaderOnConfirm: true
                }).then((result) => {
                if(result.value) {
                    this.$inertia.put(`/clinic/consultation/vaccine/second/${this.id}`)
                    this.$swal('Approved', 'Vaccination confirmed!', 'success')
                    this.$emit('close');
                } else {
                    this.$swal('Cancelled', "Nothing happened", 'info')
                    this.$emit('close');
                }
            });
        },

        booster() {
            this.$swal({
                title: 'Is the booster confirmed?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                showCloseButton: true,
                showLoaderOnConfirm: true
                }).then((result) => {
                if(result.value) {
                    this.$inertia.put(`/clinic/consultation/vaccine/booster/${this.id}`)
                    this.$swal('Approved', 'Booster confirmed!', 'success')
                    this.$emit('close');
                } else {
                    this.$swal('Cancelled', "Nothing happened", 'info')
                    this.$emit('close');
                }
            });
        },
    }
};
</script>
