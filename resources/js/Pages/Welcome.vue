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
                        <a class="btn btn-primary btn-xl" href="#about">Checkout our events</a>
                    </div>
                </div>
            </div>
        </header>
        <section class="page-section bg-primary" id="about">
            <div class="container px-4 px-lg-5">
                <vue-flux
                    :options="vfOptions"
                    :images="vfImages"
                    :transitions="vfTransitions"
                    :captions="vfCaptions"
                    ref="slider">

                    <template v-slot:preloader>
                        <flux-preloader />
                    </template>

                    <template v-slot:caption>
                        <flux-caption />
                    </template>

                    <template v-slot:controls>
                        <flux-controls />
                    </template>

                    <template v-slot:pagination>
                        <flux-pagination />
                    </template>

                    <template v-slot:index>
                        <flux-index />
                    </template>
                </vue-flux>
            </div>
        </section>
    </div>
</NavBar>
</template>
<script>
import {
   VueFlux,
   FluxCaption,
   FluxControls,
   FluxIndex,
   FluxPagination,
   FluxPreloader
} from 'vue-flux';
import Navbar from "@/Layouts/Navbar";
export default {
    created() {
        this.$page.props.events.forEach((value, index) => {
          this.vfImages.push(value.media[0].original_url)
          this.vfCaptions.push(value.description);
          console.log(this.vfImages);
          console.log(index);
      });
    },
    components: {
        Navbar,
        VueFlux,
        FluxCaption,
        FluxControls,
        FluxIndex,
        FluxPagination,
        FluxPreloader,
    },

    data() {
        return {
            vfOptions: {
               autoplay: true
            },
            vfImages: [],
            vfTransitions: [ 'fade', 'cube', 'book', 'wave' ],
            vfCaptions: [],
         };
        }
}
</script>

</html>
