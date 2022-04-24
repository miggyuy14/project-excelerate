<template>
    <div class="px-5 pt-5 bg-white">
        <form @submit.prevent="submit">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">New Event</h5>
                <div class="form-row mb-3">
                    <div class="form-group">
                        <h5 for="Tower">Description</h5>
                        <textarea class="container-fluid" v-model="form.description" type="text"></textarea>

                    </div>
                    <div class="form-group">
                        <h5 for="Title">Image</h5>
                            <vue-dropzone
                            id="attachment"
                            ref="attachments"
                            :options="dropzoneOptions"
                            @vdropzone-success="dropzoneSuccess"
                            @vdropzone-processing="dropzoneProcessing"
                            @vdropzone-sending="sendingFile"
                        >
                        </vue-dropzone>
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
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
import axios from "axios";
// import { required } from 'vuelidate/lib/validators'

export default {
    components: { Navbar, vueDropzone: vue2Dropzone },

    data() {
        return {
            isSubmitted: false,
            zones: [],
            residents: [],
            names: [],
            form: {
                attachments: [],
                description: '',
            },

            loading: {
                    submit: false,
                },

            dropzoneOptions: {
                url: "/api/attachment",
                thumbnailWidth: 150,
                parallelUploads: 1,
            },

        };
    },

    methods: {
        dropzoneProcessing() {
                this.$refs.attachments.setOption(
                    "url",
                    "/api/attachment"
                );
            },

        sendingFile(file, xhr, formData) {
                formData.append("type", "new");
            },

        dropzoneSuccess(file, response) {
                console.log(file);
                this.form.attachments.push({
                    name: response.data.name,
                    file_name: file.name,
                    original_name: file.name,
                    file_size: response.data.file_size,
                })
            },
        removeAttachment(index, attachments) {
                this.$refs.attachments.enable();
                this.$toast.warning("Attachment removed");
                this.form.attachments.splice(index, 1);
            },

        submit() {
            this.form.attachments = this.form.attachments.map((attachment) => attachment.name);
            this.$inertia.post(route('events.store'), this.form, {
                onSuccess: (page) => {
                    this.$swal('Created', 'Events created', 'success')
                    this.loading['submit'] = false;
                    this.$emit('close')
                    },
                })
        },
    }
};
</script>
