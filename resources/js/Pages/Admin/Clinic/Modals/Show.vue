<template>
    <div class="px-5 pt-5 bg-white">
        <form @submit.prevent="submit">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">New Consultation </h5>
                <div class="form-row mb-3">
                    <div class="form-group">
                        <h5 for="Tower">Request Type</h5>
                        <p>Consultation</p>
                    </div>

                    <div class="form-group">
                        <h5 for="Title">Full Description</h5>
                            <p>{{ form.description }}</p>
                    </div>

                    <div class="form-group">
                        <h5 for="Title">Consultation Date</h5>
                        <p>{{ form.date | formatDate }}</p>
                    </div>
                </div>
                <div class="form-row mb-3">
                <div class="form-group col-4">
                        <h5 for="Team">Requestor Name</h5>
                            <p>{{ form.user_name }}</p>
                    </div>
                    <div class="form-group col-4">
                        <h5 for="Team">Zone</h5>
                            <p>Zone {{ form.zone_id }}</p>
                    </div>
                </div>

                <div class="d-flex mt-3 mb-3 justify-content-end">
                    <div>
                        <button class="btn btn-warning" v-if="form.status == 'Pending' && isClinic" @click="disapprove()" :disabled="loading['submit']">
                            <span v-if="!loading['submit']">Disapprove</span>
                            <span v-else><i class="fas fa-spinner fa-spin"></i> Updating...</span>
                        </button>

                        <!-- <button v-else-if="(isUpserting && this.levels.length > 0) || (isUpserting && isSmallDifferences && matrixLoaded)" class="btn btn-primary" type="submit" :disabled="loading['submit']"> -->
                            <button class="btn btn-success" v-if="form.status == 'Pending' && isClinic" @click="approve()" :disabled="loading['submit']">
                            <span v-if="!loading['submit']">Approve</span>
                            <span v-else><i class="fas fa-spinner fa-spin"></i> Submitting. ..</span>
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

export default {
    components: { Navbar },
    props: ['id'],

    created() {
        this.getData()
    },

    data() {
        return {
            isSubmitted: false,

            form: {
                user_name: '',
                request_type: '',
                description: '',
                date: '',
                zone_id: '',
                status: '',
            },

            loading: {
                    submit: false,
                },

        };
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

    methods: {
        async getData() {
            const response = await axios.get(`/api/consultation/ticket/${this.id}`)
            this.form.user_name = response.data.patient.profile[0].full_name;
            this.form.zone_id = response.data.zone_id;
            this.form.date = response.data.consultation_date;
            this.form.description = response.data.description;
            this.form.status = response.data.status.name
            console.log(response);
        },
        store() {
            this.store();
        },
        approve() {
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
                    this.$inertia.put(`/clinic/consultation/approve/${this.id}`)
                    this.$swal('Approved', 'You successfully approved this consultation', 'success')
                } else {
                    this.$swal('Cancelled', "The consultation is still pending", 'info')
                }
                });
        },

        disapprove() {
            const {value: reason} = this.$swal.fire({
                title: 'Enter reason for rejection',
                input: 'text',
                showCancelButton: true,
                inputValidator: (value) => {
                    if (!value) {
                        return 'You need to write something!'
                    }else{
                        this.$inertia.put(`/clinic/consultation/disapprove/${this.id}`, {reason : value})
                        this.$swal('Approved', 'Consultation declined', 'success')
                    }
                }
                })

            if (reason) {

                } else {
            }
        },

        submit() {

        }

    }
};
</script>
