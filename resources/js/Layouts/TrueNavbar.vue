<template>
    <div>
        <header>
      <!-- Navigation -->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
            <div class="container">
                <a class="navbar-brand" href="#">
                Clinic System
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                    <a class="nav-link" :href="route('welcome')">Home</a>
                    </li>
                    <li class="nav-item" v-if="$page.props.auth.user !== null">
                    <Link class="nav-link" aria-current="page" :href="route('test')">Requests</Link>
                    </li>
                    <!-- <li class="nav-item" v-if="$page.props.auth.user !== null && !isResident && !isClinic">
                    <Link class="nav-link" aria-current="page" :href="route('admin.users.view')" :data="{  tab: 'resident', page: 1 }">Admin</Link>
                    </li> -->
                    <li class="nav-item" v-if="$page.props.auth.user !== null && isAdmin || isStaff || isClinic">
                    <Link class="nav-link" aria-current="page" :href="route('clinic.index')" :data="{  tab: 'consultation', page: 1 }">Clinic</Link>
                    </li>
                    <li class="nav-item" v-if="$page.props.auth.user !== null">
                    <Link class="nav-link" aria-current="page" :href="route('logout')">Logout</Link>
                    </li>
                    <div v-if="$page.props.auth.user !== null">
                    <li class="nav-item dropdown">
                    <a class="nav-link " href="#"  role="button"  aria-expanded="false">
                        {{ $page.props.auth.user.profile[0].full_name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" :href="route('logout')">Logout</a></li>
                    </ul>
                    </li>
                    </div>
                    <div v-else>
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Sign In
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" :href="route('login')">Login</a></li>
                        <li><a class="dropdown-item" :href="route('register')">Register</a></li>
                    </ul>
                    </li>
                    </div>
                </ul>
                </div>
            </div>
            </nav>
        </header>

        <!-- Page Content -->
    <main class="main-content container pt-lg-2">
      <slot></slot>
    </main>

        <!-- <footer> @include('partials.footer') </footer> -->

    </div>
</template>
<script>
import { Link } from "@inertiajs/inertia-vue";
import axios from "axios";
import Addtnls from "../Mixins/AdditionalMixins.js"
export default {
    components: { Link },

    data() {
        return {
        }
    },
    computed: {
        isAdmin() {
                if(this.$page.props.auth.roles.includes('admin')){
                    return true;
                }else{
                    return false;
                }
            },
        isStaff() {
            if(this.$page.props.auth.roles.includes('staff')){
                return true;
            }else{
                return false;
            }
            },
        isZoneLeader() {
            if(this.$page.props.auth.roles.includes('zone_leader')){
                return true;
            }else{
                return false;
            }
        },
        isResident() {
            if(this.$page.props.auth.roles.includes('resident')){
                return true;
            }else{
                return false;
            }
        },
        isClinic() {
            if(this.$page.props.auth.roles.includes('doctor') || this.$page.props.auth.roles.includes('nurse')){
                return true;
            }else{
                return false;
            }
        },
    },

    watch: {
        '$page.props.flash': {
        handler(flash) {
            if (flash.error) {
            // this.$toast.error(flash.error);
            } else if (flash.success) {
            // this.$toast.success(flash.success);
            }
        },
        deep: true
        }
    },

    methods: {

    }
}
</script>
