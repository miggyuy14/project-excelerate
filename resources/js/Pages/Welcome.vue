<template>
<Navbar>
    <!-- <center>
    <h1>This is the homepage</h1>
    </center> -->
    <div id="page-top">
        <!-- Navigation-->

        <!-- Masthead-->
        <header class="masthead" >
            <div class="container px-4 px-lg-5 h-100">
                <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-8 align-self-end">
                        <h1 class="text-white font-weight-bold">Development of Barangay Information Vaccination Rollout</h1>
                        <hr class="divider" />
                    </div>
                    <div class="col-lg-8 align-self-baseline">
                        <p class="text-white-75 mb-5">This System will help not only the citizens within the barangay but also the barangay and clinic it self will benefit using the system Development of Barangay Information Vaccination Rollout</p>
                        <a class="btn btn-primary btn-xl" :href="route('ticket.index')">Get Started</a>
                    </div>
                </div>
            </div>
        </header>
    </div>
</NavBar>
</template>
<script>
import Navbar from "@/Layouts/Navbar";
export default {
    components: {
        Navbar
    }
}
</script>

</html>
