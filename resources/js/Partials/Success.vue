<template>
    <b-row class="mt-2 mb-2">
        <b-col sm="12">
            <b-alert v-if="message" variant="success" dismissible show>
                {{ message}}
            </b-alert>
        </b-col>
    </b-row>
</template>

<script>
export default {
    props: {
        message: String
    },
}
</script>
