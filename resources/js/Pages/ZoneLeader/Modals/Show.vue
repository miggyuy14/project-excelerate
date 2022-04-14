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
                            <input v-if="form.status == 'pending'" class="container-fluid" v-model="form.or_no" type="text">
                            <p v-else>{{form.ticket.or_no}}</p>

                        <!-- <small v-if="isSubmitted && !$v.form.titleHolder.required" class="text-danger">Title is required</small> -->
                    </div>
                    <div class="form-group">
                        <h5 for="Title">Amount to pay</h5>
                            <input v-if="form.status == 'pending'" class="container-fluid" v-model="form.amount" type="number">
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
                        <h5 v-if="form.status == 'approved'" for="Team">Approved by</h5>
                        <h5 v-if="form.status == 'disapproved'" for="Team">Declined by</h5>
                            <p>{{ form.approver.full_name }}</p>
                    </div>
                    <div v-if="form.status == 'disapproved'" class="form-group">
                        <h5 for="Team">Reason</h5>
                            <p>{{ form.ticket.reason }}</p>
                    </div>
                </div>

                <div class="d-flex mt-3 mb-3 justify-content-end">
                    <div>
                        <button class="btn btn-warning" v-if="form.status == 'pending'" @click="disapprove()" :disabled="loading['submit']">
                            <span v-if="!loading['submit']">Disapprove</span>
                            <span v-else><i class="fas fa-spinner fa-spin"></i> Updating...</span>
                        </button>

                        <!-- <button v-else-if="(isUpserting && this.levels.length > 0) || (isUpserting && isSmallDifferences && matrixLoaded)" class="btn btn-primary" type="submit" :disabled="loading['submit']"> -->
                            <button class="btn btn-success" v-if="form.status == 'pending'" @click="approve()" :disabled="loading['submit']">
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
        // dropzoneProcessing() {
        //     this.$refs.attachments.setOption(
        //         "url",
        //         "/api/v1/attachment"
        //     );
        //     },

        // sendingFile(file, xhr, formData) {
        //     formData.append("type", "new");
        //     },

        // dropzoneSuccess(file, response) {
        //     console.log(file);
        //     this.form.attachments.push({
        //         name: response.data.name,
        //         file_name: file.name,
        //         original_name: file.name,
        //         file_size: response.data.file_size,
        //     })
        //     },
        // removeAttachment(index, attachments) {
        //     this.$refs.attachments.enable();
        //     this.$toast.warning("Attachment removed");
        //     this.form.attachments.splice(index, 1);
        //     },
        store() {
            this.store();
        },
        // submit() {
        //     try {
        //         this.isSubmitted = true;
        //         this.loading['submit'] = true;
        //         // if (this.$v.$invalid)
        //         // {
        //         //     this.$toast.error("Please check your input fields");
        //         //     this.loading["submit"] = false;
        //         //     return;
        //         // }
        //         // this.form.attachments = this.form.attachments.map((attachment) => attachment.name);
        //         this.$inertia.post(route('ticket.approve'), this.form, {
        //             onSuccess: (page) => {
        //                 this.$toast.success(this.$page.props.flash.success);
        //                 this.loading['submit'] = false;
        //                 this.$emit('close');
        //             },
        //         })

        //     }catch (error) {

        //     }
        // },
        approve() {
            this.$inertia.put(`/tickets/${this.id}/approve`, this.form);
            this.$emit('close');
        },
        disapprove() {
            this.$inertia.put(`/tickets/${this.id}/disapprove`);
        },

    }
};
</script>
