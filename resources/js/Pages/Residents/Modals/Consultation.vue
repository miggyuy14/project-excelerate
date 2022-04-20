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
                        <!-- <small v-if="isSubmitted && !$v.form.towerHolder.required" class="text-danger">Tower is required</small> -->
                    </div>

                    <div class="form-group">
                        <h5 for="Title">Full Description</h5>
                            <textarea class="container-fluid" v-model="form.description" type="text"></textarea>

                        <!-- <small v-if="isSubmitted && !$v.form.titleHolder.required" class="text-danger">Title is required</small> -->
                    </div>

                    <div class="form-group">
                        <h5 for="Title">Consultation Date</h5>
                        <input class="container-fluid" type="date" v-model="form.date">
                    </div>

                    <!-- <div class="form-group col-4">
                        <h5 for="Country">Description</h5>
                            <v-select name="country" :options="country" label="name" v-model="form.countryHolder"></v-select> -->

                        <!-- <small v-if="isSubmitted && !$v.form.countryHolder.required" class="text-danger">Country is required</small> -->
                    <!-- </div> -->
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
                            <button class="btn btn-lg btn-primary" type="submit" :disabled="loading['submit']">
                            <span v-if="!loading['submit']">Submit</span>
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
        this.getTypes();
    },

    data() {
        return {
            isSubmitted: false,

            form: {
                user_name: this.$page.props.auth.user.profile[0].full_name,
                request_type: '',
                description: '',
                date: '',
                zone_id: this.$page.props.auth.user.profile[0].zone_id,
            },

            loading: {
                    submit: false,
                },

        };
    },

    methods: {
        async getTypes() {
            const response = await axios.get('/api/types');
            this.types = response.data;
            console.log(this.types);
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
        async handleImageAdded (file, Editor, cursorLocation, resetUploader) {

            var formData = new FormData();
            formData.append("file", file);
            console.log(formData);

            axios({
                url: "/api/v1/image",
                method: "POST",
                data: formData
            }).then(result => {
                    const url = result.data.data.url; // Get url from response
                    console.log(url);
                    Editor.insertEmbed(cursorLocation, "image", url);
                        resetUploader();
                })
                .catch(err => {
                    console.log(err);
                });
        },

    }
};
</script>
