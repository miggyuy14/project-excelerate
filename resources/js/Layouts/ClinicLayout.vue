<template>
    <Navbar>
    <div>
        <div class="row justify-content-center">
                    <!-- count cards -->
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-5 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Residents</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ residents }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-5 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Consultations</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ tickets }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-5 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Doctors</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ doctors }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-ticket-alt fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-5 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Nurses</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ nurses }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <!-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> -->
                                            <i class="fas fa-ticket-alt fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
        </div>

        <div class="library-layout">
        <div class="px-5 container-fluid">
            <div class="d-flex justify-content-between">
                <h3>Clinic Dashboard</h3>
                <button class="btn btn-primary" v-if="currentTabComponent == 'nurse'" @click="nurse()"> Add nurse </button>
                <button class="btn btn-primary" v-if="currentTabComponent == 'doctor'" @click="doctor()"> Add doctor </button>
                <button class="btn btn-primary" v-if="currentTabComponent == 'inventory'" @click="inventory()"> Add item </button>
            </div>
                <ul class='nav nav-tabs'>
                    <li class="nav-item">
                        <Link class="nav-link" :href="route('clinic.index')" :data="{  tab: 'consultation', page: 1 }" :class="(currentTabComponent == 'consultation') ? 'active': 'text-gray-500 bg-gray-200'">Consultations</Link>
                    </li>
                    <li class="nav-item">
                        <Link class="nav-link" :href="route('clinic.nurse')" :data="{  tab: 'nurse', page: 1 }" :class="(currentTabComponent == 'nurse') ? 'active': 'text-gray-500 bg-gray-200'">Nurses</Link>
                    </li>
                    <li class="nav-item">
                        <Link class="nav-link" :href="route('clinic.doctor')" :data="{ tab: 'doctor', is_paginated: true, page: 1 }"  :class="(currentTabComponent == 'doctor') ? 'active': 'text-gray-500 bg-gray-200'">Doctors</Link>
                    </li>
                    <li class="nav-item">
                        <Link class="nav-link" :href="route('clinic.inventory')" :data="{ tab: 'inventory', is_paginated: true, page: 1 }"  :class="(currentTabComponent == 'inventory') ? 'active': 'text-gray-500 bg-gray-200'">Inventory</Link>
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
import nurse from '@/Pages/Admin/Clinic/Modals/CreateNurse.vue'
import doctor from '@/Pages/Admin/Clinic/Modals/CreateDoctor.vue'
import inventory from '@/Pages/Admin/Clinic/Inventory/Create.vue'
export default {
    components: { Navbar, Link },
    props: ['search', 'country', 'process', 'tower', 'department', 'team'],

    data() {
        return {
            currentTabComponent: new URL(location.href).searchParams.get('tab') ?? 'resident',

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
        this.getResidents();
        this.getDoctors();
        this.getTickets();
        this.getNurses();
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

        nurse(){
            this.$modal.show(
                nurse,
                {

                },
                {
                    height: "450px",
                },
            )
        },

        doctor(){
            this.$modal.show(
                doctor,
                {

                },
                {
                    height: "450px",
                },
            )
        },

        inventory(){
            this.$modal.show(
                inventory,
                {

                },
                {
                    height: "450px",
                },
            )
        },

        async getResidents(){
            const response = await axios.get('/api/residents');
            this.residents = response.data;
        },
        async getDoctors(){
            const response = await axios.get('/api/doctors');
            this.doctors = response.data;
        },
        async getTickets(){
            const response = await axios.get('/api/consultations');
            this.tickets = response.data;
        },
        async getNurses(){
            const response = await axios.get('/api/nurses');
            this.nurses = response.data;
        },
    }
}
</script>
