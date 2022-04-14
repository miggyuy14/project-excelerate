<template>
    <div>
        <header>
            <!-- <navbar>
                <form id="logout-form" :action="logoutRoute" method="POST" style="display: none;">
                    <input type="hidden" name="_token" :value="token">
                </form>
            </navbar> -->
            <!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand d-flex align-items-center" href="#">
                Logo Here
            </a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
            </li>
            <li class="nav-item">
            </li>
            <li class="nav-item dropdown">
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <div class="dropdown-divider"></div>
              </div>
            </li>
            <li class="nav-item">
            </li>
          </ul>
          <div class="justify-content-end">
          <form class="form-inline">
            <Link class="nav-link" :href="route('welcome')" exact>Home</Link>
             <Link class="nav-link" :href="route('documents')" :data="{ tab: 'documents', is_paginated: true, page: 1 }">Library</Link> -->
            <!-- WIP -->
            <!-- <Link class="nav-link" v-if="isAdmin" :href="route('admin.users.view')" :data="{ tab: 'users', is_paginated: true, page: 1 }">Admin</Link> -->

            <!-- <li class="nav-item d-flex flex-column justify-content-center">
                    <div class="dropdown" v-if="$page.props.auth.user !== null">
                        <div class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{$page.props.auth.user.profile[0].full_name}}</div>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" :href="route('logout')"> Logout </a>
                        </div>
                    </div>
                    <div class="dropdown" v-else>
                        <Link class="nav-link" :href="route('login')" exact>Login</Link>
                        <Link class="nav-link" :href="route('register')" exact>Register</Link>
                    </div>
                </li>
          </form>
          </div>
        </div>
      </nav> -->

      <!-- Navigation -->
<!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
  <div class="container">
    <a class="navbar-brand" href="#">
      <img src="https://placeholder.pics/svg/150x50/888888/EEE/Logo" alt="..." height="36">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item" v-if="$page.props.auth.user !== null">
          <Link class="nav-link" :href="route('ticket.index')">Requests</Link>
        </li>
        <div v-if="$page.props.auth.user !== null">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
</nav> -->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="#page-top">Barangay San Isidro</a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto my-2 my-lg-0">
                        <li class="nav-item"><Link class="nav-link" :href="route('welcome')">Home</Link></li>
                        <li class="nav-item" v-if="$page.props.auth.user !== null">
                            <Link class="nav-link" :href="route('ticket.index')">Requests</Link>
                        </li>
                        <li class="nav-item" v-if="$page.props.auth.user !== null && isAdmin || isStaff || isZoneLeader">
                            <Link class="nav-link" :href="route('admin.users.view')" :data="{  tab: 'resident', page: 1 }">Admin</Link>
                        </li>
                        <li class="nav-item" v-if="$page.props.auth.user == null">
                            <a class="nav-link" :href="route('login')">Login</a>
                        </li>
                        <li class="nav-item" v-if="$page.props.auth.user == null">
                            <a class="nav-link" :href="route('register')">Register</a>
                        </li>
                        <li class="nav-item" v-if="$page.props.auth.user !== null"><a class="nav-link" :href="route('logout')">Logout</a></li>
                        <li class="nav-item dropdown" v-if="$page.props.auth.user !== null">
                        <a class="nav-link" href="#" id="navbarDropdown" role="button" aria-expanded="false">
                            {{ $page.props.auth.user.profile[0].full_name }}
                        </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        </header>

        <!-- Page Content -->
    <main>
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
        }
    },

    watch: {
        '$page.props.flash': {
        handler(flash) {
            if (flash.error) {
            this.$toast.error(flash.error);
            } else if (flash.success) {
            this.$toast.success(flash.success);
            }
        },
        deep: true
        }
    },

    methods: {

    }
}
</script>
