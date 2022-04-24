<template>
    <div class="px-5 pt-5 bg-white">
        <form @submit.prevent="submit">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ form.status }} Request </h5>
                <div class="form-row mb-3">
                    <div class="form-group">
                        <h5 for="Tower">Request Type</h5>
                        <p>{{ form.request_type }}</p>
                        <!-- <small v-if="isSubmitted && !$v.form.towerHolder.required" class="text-danger">Tower is required</small> -->
                    </div>
                    <div class="form-group">
                        <h5 for="Title">Full Description</h5>
                            <p>{{ form.description }}</p>

                        <!-- <small v-if="isSubmitted && !$v.form.titleHolder.required" class="text-danger">Title is required</small> -->
                    </div>
                    <div class="form-group">
                        <h5 for="Title">OR Number</h5>
                            <input v-if="form.status == 'Pending' && !isResident" class="container-fluid" v-model="form.or_no" type="text">
                            <p v-else>{{form.ticket.or_no}}</p>

                        <!-- <small v-if="isSubmitted && !$v.form.titleHolder.required" class="text-danger">Title is required</small> -->
                    </div>
                    <div class="form-group">
                        <h5 for="Title">Amount to pay</h5>
                            <input v-if="form.status == 'Pending' && !isResident" class="container-fluid" v-model="form.amount" type="number">
                            <p v-else>{{form.ticket.amount}}.00</p>
                        <!-- <small v-if="isSubmitted && !$v.form.titleHolder.required" class="text-danger">Title is required</small> -->
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="form-group">
                        <h5 for="Team">Requestor Name</h5>
                            <p>{{ form.requestor.full_name }}</p>
                    </div>
                    <div class="form-group">
                        <h5 for="Team">Requestor address</h5>
                            <p>{{ form.requestor.address }}</p>
                    </div>
                    <div class="form-group">
                        <h5 for="Team">Zone</h5>
                            <p>Zone {{ form.ticket.zone_id }}</p>
                    </div>
                    <div class="form-group">
                        <h5 v-if="form.status.name == 'Approved'" for="Team">Approved by</h5>
                        <h5 v-if="form.status.name == 'Disapproved'" for="Team">Declined by</h5>
                            <p>{{ form.approver.full_name }}</p>
                    </div>
                    <div v-if="form.status.name == 'Disapproved'" class="form-group">
                        <h5 for="Team">Reason</h5>
                            <p>{{ form.ticket.reason }}</p>
                    </div>
                </div>

                <div class="d-flex mt-3 mb-3 justify-content-end">
                    <div>
                        <button class="btn btn-warning" v-if="form.status == 'Pending' && !isResident && !isClinic" @click="disapprove()" :disabled="loading['submit']">
                            <span v-if="!loading['submit']">Disapprove</span>
                            <span v-else><i class="fas fa-spinner fa-spin"></i> Updating...</span>
                        </button>

                        <!-- <button v-else-if="(isUpserting && this.levels.length > 0) || (isUpserting && isSmallDifferences && matrixLoaded)" class="btn btn-primary" type="submit" :disabled="loading['submit']"> -->
                            <button class="btn btn-success" v-if="form.status == 'Pending' && !isResident && !isClinic" @click="approve()" :disabled="loading['submit']">
                            <span v-if="!loading['submit']">Approve</span>
                            <span v-else><i class="fas fa-spinner fa-spin"></i> Submitting. ..</span>
                        </button>

                        <button class="btn btn-success" v-if="isClinic" @click="first_dose()" :disabled="loading['submit']">
                            <span v-if="!loading['submit']">Add first dose</span>
                            <span v-else><i class="fas fa-spinner fa-spin"></i> Submitting. ..</span>
                        </button>

                        <button class="btn btn-success" v-if="isClinic" @click="second_dose()" :disabled="loading['submit']">
                            <span v-if="!loading['submit']">Add second dose</span>
                            <span v-else><i class="fas fa-spinner fa-spin"></i> Submitting. ..</span>
                        </button>

                        <button class="btn btn-success" v-if="isClinic" @click="booster()" :disabled="loading['submit']">
                            <span v-if="!loading['submit']">Add booster</span>
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
// import { required } from 'vuelidate/lib/validators'

export default {
    components: { Navbar },
    props: ['id'],
    // validations: {
    //     form: {
            // titleHolder: {
            //     required
            // },
            // countryHolder: {
            //     required
            // },
            // towerHolder: {
            //     required
            // },
            // teamHolder: {
            //     required
            // },
            // departmentHolder: {
            //     required
            // },
            // processHolder: {
            //     required
            // },
            // overview: {
            //     required
            // },
            // processMap: {
            //     required
            // },
            // definition: {
            //     required
            // },
            // procedure: {
            //     required
            // },
    //     },
    // },

    computed: {
            isAdmin() {
                if(this.$page.props.auth.roles.includes('admin')){
                    return true;
                }else{
                    return false;
                }
            },
            isStaff() {
                if(this.$page.props.auth.roles.includes('staff')){
                    return true;
                }else{
                    return false;
                }
            },
            isZoneLeader() {
                if(this.$page.props.auth.roles.includes('zone_leader')){
                    return true;
                }else{
                    return false;
                }
            },
            isResident() {
                if(this.$page.props.auth.roles.includes('resident')){
                    return true;
                }else{
                    return false;
                }
            },
            isClinic() {
            if(this.$page.props.auth.roles.includes('doctor') || this.$page.props.auth.roles.includes('nurse')){
                return true;
            }else{
                return false;
            }
        },
    },

    created() {
        this.getTicketDetails();
    },

    data() {
        return {
            isSubmitted: false,

            form: {
                user_name: this.$page.props.auth.user.profile[0].full_name,
                address: this.$page.props.auth.user.profile[0].address,
                request_type: '',
                description: '',
                zone_id: this.$page.props.auth.user.profile[0].zone_id,
                or_no: '',
                amount: '',
                requestor: '',
                status: '',
                ticket: '',
                approver: '',
            },

            loading: {
                    submit: false,
                },

        };
    },

    methods: {
        async getTicketDetails() {
            const response = await axios.get(`/api/ticket/${this.id}`);
            this.form.ticket = response.data;
            this.form.request_type = response.data.request_type;
            this.form.description = response.data.description;
            this.form.requestor = response.data.requestor.profile;
            this.form.status = response.data.status.name;
            this.form.approver = response.data.approver.profile
            console.log(this.form.requestor);
        },
        store() {
            this.store();
        },
        approve() {
            this.$inertia.put(`/tickets/${this.id}/approve`, this.form);
            this.$emit('close');
        },
        disapprove() {
            this.$inertia.put(`/tickets/${this.id}/disapprove`);
            this.$emit('close');
        },


    }
};
</script>
