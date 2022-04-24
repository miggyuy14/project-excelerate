
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

    created() {
        this.getResident();
    },

    data() {
        return {
            currentTabComponent: new URL(location.href).searchParams.get('tab'),
            isSubmitted: false,

            // countries: [],
            // departments: [],
            // processes: [],
            // towers: [],
            // types: [],
            // form: {
            //     user_name: this.$page.props.auth.user.profile[0].full_name,
            //     request_type: '',
            //     description: '',
            //     zone_id: this.$page.props.auth.user.profile[0].zone_id,
            // },
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
    }
};
</script>
