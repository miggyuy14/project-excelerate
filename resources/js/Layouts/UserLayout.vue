<template>
    <Navbar>
    <div>
        <!-- <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn mt-4" @click="closeNav()">
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </span></a>

                <div class="px-3">
                    <div class="text-2md">
                        Filter by:
                    </div>
                    <div>
                    <label for="Tower">Tower</label>
                    <v-select name="Tower" label="name"></v-select>
                </div>
                <div>
                    <label for="Country">Country</label>
                    <v-select name="Country" label="name" ></v-select>
                </div>
                <div>
                    <label for="Process">Process</label>
                    <v-select name="Process" label="name"></v-select>
                </div>
                <div>
                    <label for="Department">Department</label>
                    <v-select name="Department" label="name"></v-select>
                </div>
                <div>
                    <label for="Team">Team</label>
                    <v-select name="Team" label="name"></v-select>
                </div>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mt-5 w-full rounded " @click="filter()">
                Filter
            </button>
            </div>

        </div>
        <span class="float-right mr-6 bg-gray-200 p-3" @click="openNav()">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2"
                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1
                    0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
        </span> -->

        <div class="library-layout">
        <div class="px-5 container-fluid">
            <div class="d-flex justify-content-between">
                <h3>Library</h3>
                <Link class="btn btn-primary" v-if="isAdmin" :href="route('document.create')"> Create New Document </Link>
            </div>
                <ul class='nav nav-tabs'>
                    <li class="nav-item">
                        <Link class="nav-link" :href="route('documents')" :data="{ tab: 'documents', is_paginated: true, page: 1 }" :class="(currentTabComponent == 'documents') ? 'active': 'text-gray-500 bg-gray-200'">All Documents</Link>
                    </li>
                    <li class="nav-item">
                        <Link class="nav-link" :href="route('revisions')" :data="{ tab: 'requests', is_paginated: true, page: 1 }"  :class="(currentTabComponent == 'requests') ? 'active': 'text-gray-500 bg-gray-200'">Requests</Link>
                    </li>
                    <li class="nav-item">
                        <Link class="nav-link" :href="route('documents')" :data="{ tab: 'bookmarks', is_paginated: true, page: 1 }"  :class="(currentTabComponent == 'bookmarks') ? 'active': 'text-gray-500 bg-gray-200'">Bookmarks</Link>
                    </li>
                    <li class="nav-item" v-if="isAdmin">
                        <Link class="nav-link" :href="route('documents')" :data="{ tab: 'approvals', is_paginated: true, page: 1 }"  :class="(currentTabComponent == 'approvals') ? 'active': 'text-gray-500 bg-gray-200'">For Approvals</Link>
                    </li>
                    <li class="nav-item" v-if="isAdmin">
                        <Link class="nav-link" :href="route('documents')" :data="{ tab: 'archives', is_paginated: true, page: 1 }"  :class="(currentTabComponent == 'archives') ? 'active': 'text-gray-500 bg-gray-200'">Archives</Link>
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
import Navbar from './Navbar';
export default {
    components: { Navbar, Link },
    props: ['search', 'country', 'process', 'tower', 'department', 'team'],

    data() {
        return {
            currentTabComponent: new URL(location.href).searchParams.get('tab') ?? 'documents',
            attributes: [
                {search: this.search},
                {country: this.country},
                {process: this.process},
                {tower: this.tower},
                {department: this.department},
                {team: this.team}
            ],

            // state: {
            //     search: this.search,
            // },
        }
    },
    computed: {
        isAdmin(){
            if(this.$page.props.auth.roles.includes('admin')){
                return true;
            }else{
                return false;
            }
        }
    },
    methods: {
        /* Set the width of the side navigation to 250px */
        openNav() {
        document.getElementById("mySidenav").style.width = "250px";
        },

        /* Set the width of the side navigation to 0 */
        closeNav() {
        document.getElementById("mySidenav").style.width = "0";
        },
    }
}
</script>
