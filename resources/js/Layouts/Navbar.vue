<template>
    <div>
        <header>
            <!-- <navbar>
                <form id="logout-form" :action="logoutRoute" method="POST" style="display: none;">
                    <input type="hidden" name="_token" :value="token">
                </form>
            </navbar> -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
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
          <form class="form-inline">
            <Link class="nav-link" :href="route('welcome')" exact>Home</Link>
            <!-- <Link class="nav-link" :href="route('documents')" :data="{ tab: 'documents', is_paginated: true, page: 1 }">Library</Link> -->
            <!-- WIP -->
            <!-- <Link class="nav-link" v-if="isAdmin" :href="route('admin.users.view')" :data="{ tab: 'users', is_paginated: true, page: 1 }">Admin</Link> -->

            <li class="nav-item d-flex flex-column justify-content-center">
                    <div class="dropdown" v-if="$page.props.auth !== null">
                        <div class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{$page.props.auth.user.profile.full_name}}</div>
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
      </nav>
        </header>

        <!-- Page Content -->
    <main class="main-content">
      <slot></slot>
    </main>

        <!-- <footer> @include('partials.footer') </footer> -->

    </div>
</template>
<script>
import { Link } from "@inertiajs/inertia-vue";
export default {
    components: { Link },

    data() {
        return {
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
