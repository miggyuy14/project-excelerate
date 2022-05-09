<template>
    <Navbar>
    <div>
        <div class="library-layout">
        <div class="px-5 container-fluid pt-lg-5">
            <div class="d-flex justify-content-between">
            <h3>Requests</h3>
                <button class="btn btn-primary" v-if="currentTabComponent == 'tickets'" @click="ticket()"> Create Request </button>
                <button class="btn btn-primary" v-if="currentTabComponent == 'consultation'" @click="consultation()"> Create Consultation </button>
                <!-- <button class="btn btn-primary" v-if="currentTabComponent == 'inventory'" @click="inventory()"> Add item </button> -->
            </div>
                <ul class='nav nav-tabs'>
                    <!-- <li class="nav-item">
                        <Link class="nav-link" :href="route('ticket.index')" :data="{  tab: 'tickets', page: 1 }" :class="(currentTabComponent == 'tickets') ? 'active': 'text-gray-500 bg-gray-200'">Tickets</Link>
                    </li> -->
                    <li class="nav-item">
                        <Link class="nav-link" :href="route('test')" :data="{  tab: 'consultation', page: 1 }" :class="(currentTabComponent == 'consultation') ? 'active': 'text-gray-500 bg-gray-200'">Consultations</Link>
                    </li>
                 </ul>
            </div>
        </div>

        <slot></slot>
    </div>
    </Navbar>
</template>
<script>
import { Link } from "@inertiajs/inertia-vue";
import Navbar from '@/Layouts/TrueNavbar'
import axios from 'axios';
import Create from '@/Pages/Residents/Modals/Create.vue';
import ConsultationVue from '@/Pages/Residents/Modals/Consultation.vue';
export default {
    components: { Navbar, Link },

    data() {
        return {
            currentTabComponent: new URL(location.href).searchParams.get('tab') ?? 'consultation',

            residents: '',
            doctors: '',
            tickets: '',
            nurses: '',

            // state: {
            //     search: this.search,
            // },
        }
    },
    created() {
    },
    computed: {
        isAdmin(){
            if(this.$page.props.auth.roles.includes('admin')){
                return true;
            }else{
                return false;
            }
        },
        isStaff(){
            if(this.$page.props.auth.roles.includes('staff')){
                return true;
            }else{
                return false;
            }
        },
        isZoneLeader(){
            if(this.$page.props.auth.roles.includes('zone_leader')){
                return true;
            }else{
                return false;
            }
        }

    },
    methods: {

        ticket(){
            this.$modal.show(
                Create,
                {

                },
                {
                    height: "auto",
                    scrollable: true,
                },
            )
        },

        consultation(){
            this.$modal.show(
                ConsultationVue,
                {

                },
                {
                    height: "auto",
                    scrollable: true,
                },
            )
        },
    }
}
</script>
