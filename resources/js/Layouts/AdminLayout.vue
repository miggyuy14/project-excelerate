<template>
    <Navbar>
    <div>
        <div class="row justify-content-center">
                    <!-- count cards -->
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-2 col-md-5 mb-4 mx-3">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Officials</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ brgy }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-2 col-md-5 mb-4 mx-3">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
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
                        <div class="col-xl-2 col-md-5 mb-4 mx-3">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Blotters</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ blotter }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-ticket-alt fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-2 col-md-5 mb-4 mx-3">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Tickets</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ tickets }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <!-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> -->
                                            <i class="fas fa-ticket-alt fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-2 col-md-5 mb-4 mx-3">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Events</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ eventsCount }}</div>
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
                <h3>Admin Dashboard</h3>
                <button class="btn btn-primary" v-if="currentTabComponent == 'blotter'" @click="Create()"> Create blotter </button>
                <button class="btn btn-primary" v-if="currentTabComponent == 'official'" @click="official()"> Add officials </button>
                <button class="btn btn-primary" v-if="currentTabComponent == 'leader'" @click="leader()"> Add Zone Leader </button>
                <button class="btn btn-primary" v-if="currentTabComponent == 'events'" @click="events()"> Create Event </button>
            </div>
                <ul class='nav nav-tabs'>
                    <li class="nav-item">
                        <Link class="nav-link" :href="route('admin.users.view')" :data="{  tab: 'resident', page: 1 }" :class="(currentTabComponent == 'resident') ? 'active': 'text-gray-500 bg-gray-200'">Residents</Link>
                    </li>
                    <li class="nav-item">
                        <Link class="nav-link" :href="route('admin.users.pending.view')" :data="{  tab: 'Access Request View', page: 1 }" :class="(currentTabComponent == 'Access Request View') ? 'active': 'text-gray-500 bg-gray-200'">Access Request</Link>
                    </li>
                    <li class="nav-item">
                        <Link class="nav-link" v-if="isAdmin || isStaff" :href="route('admin.officials.view')" :data="{ tab: 'official', is_paginated: true, page: 1 }"  :class="(currentTabComponent == 'official') ? 'active': 'text-gray-500 bg-gray-200'">Brgy Officials</Link>
                    </li>
                    <li class="nav-item">
                        <Link class="nav-link" v-if="isAdmin || isStaff" :href="route('admin.leaders.view')" :data="{ tab: 'leader', is_paginated: true, page: 1 }"  :class="(currentTabComponent == 'leader') ? 'active': 'text-gray-500 bg-gray-200'">Zone Leaders</Link>
                    </li>
                    <li class="nav-item">
                        <Link class="nav-link" v-if="isAdmin || isStaff" :href="route('admin.blotter')" :data="{ tab: 'blotter', is_paginated: true, page: 1 }"  :class="(currentTabComponent == 'blotter') ? 'active': 'text-gray-500 bg-gray-200'">Blotter</Link>
                    </li>
                    <li class="nav-item">
                        <Link class="nav-link" v-if="isAdmin || isStaff" :href="route('admin.events')" :data="{ tab: 'events', is_paginated: true, page: 1 }"  :class="(currentTabComponent == 'events') ? 'active': 'text-gray-500 bg-gray-200'">Events</Link>
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
import Create from '@/Pages/Admin/Blotter/Modals/Create'
import officials from '@/Pages/Admin/CreateOfficial.vue'
import leader from '@/Pages/Admin/CreateLeader.vue'
import events from '@/Pages/Admin/Events/create.vue'
export default {
    components: { Navbar, Link },
    props: ['search', 'country', 'process', 'tower', 'department', 'team'],

    data() {
        return {
            currentTabComponent: new URL(location.href).searchParams.get('tab') ?? 'resident',

            residents: '',
            brgy: '',
            tickets: '',
            blotter: '',
            eventsCount: '',

            // state: {
            //     search: this.search,
            // },
        }
    },
    created() {
        this.getResidents();
        this.getBrgy();
        this.getTickets();
        this.getBlotter();
        this.getEvents();
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

        Create(){
            this.$modal.show(
                Create,
                {

                },
                {
                    height: "450px",
                    scrollable: true,
                },
            )
        },

        official(){
            this.$modal.show(
                officials,
                {

                },
                {
                    height: "450px",
                    scrollable: true,
                },
            )
        },

        leader(){
            this.$modal.show(
                leader,
                {

                },
                {
                    height: "450px",
                    scrollable: true,
                },
            )
        },

        events(){
            this.$modal.show(
                events,
                {

                },
                {
                    height: "auto ",
                    scrollable: true,
                },
            )
        },

        async getResidents(){
            const response = await axios.get('/api/residents');
            this.residents = response.data;
        },
        async getBrgy(){
            const response = await axios.get('/api/brgy');
            this.brgy = response.data;
        },
        async getTickets(){
            const response = await axios.get('/api/tickets');
            this.tickets = response.data;
        },
        async getBlotter(){
            const response = await axios.get('/api/blotters');
            this.blotter = response.data;
        },

        async getEvents(){
            const response = await axios.get('/api/events');
            this.eventsCount = response.data;
        },
    }
}
</script>
