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

                    <div class="form-group">
                        <h5 for="Title">Findings</h5>
                        <p>{{ form.findings }}</p>
                    </div>
                    <div v-if="form.status == 'Disapprove'" class="form-group">
                        <h5 for="Title">Reason for rejection</h5>
                        <p>{{ form.reason }}</p>
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
                            <!-- <button class="btn btn-lg btn-primary" type="submit" :disabled="loading['submit']">
                            <span v-if="!loading['submit']">Submit</span>
                            <span v-else><i class="fas fa-spinner fa-spin"></i> Submitting. ..</span>
                        </button> -->

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
        this.getData()
    },

    data() {
        return {
            isSubmitted: false,

            form: {
                user_name: '',
                request_type: '',
                description: '',
                findings: '',
                date: '',
                status: '',
                zone_id: '',
                reason: '',
            },

            loading: {
                    submit: false,
                },

        };
    },

    methods: {
        async getData() {
            const response = await axios.get(`/api/consultation/ticket/${this.id}`)
            this.form.user_name = response.data.patient.profile[0].full_name;
            this.form.zone_id = response.data.patient.profile[0].zone_id;
            this.form.date = response.data.consultation_date;
            this.form.status = response.data.status.name;
            this.form.description = response.data.description;
            this.form.findings = response.data.findings;
            this.form.reason = response.data.reason;
            console.log(response);
        },
        store() {
            this.store();
        },
        submit() {
            try {
                this.isSubmitted = true;
                this.loading['submit'] = true;
                // if (this.$v.$invalid)
                // {
                //     this.$toast.error("Please check your input fields");
                //     this.loading["submit"] = false;
                //     return;
                // }
                // this.form.attachments = this.form.attachments.map((attachment) => attachment.name);
                this.$inertia.post(route('clinic.consultation.store'), this.form, {
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
