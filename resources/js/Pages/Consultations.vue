<template>
    <Navbar>
    <div class="px-5 bg-white">
        <Success :message="this.$page.props.flash.success"></Success>
        <Error :message="this.$page.props.flash.error"></Error>
        <div class="container-fluid items-center justify-center px-5">
            <h2>Consultations</h2>
            <div class="d-flex justify-content-between">
                <input class="shadow appearance-none border rounded py-2 px-3 mb-4 " id="search" type="text" placeholder="Search. . .">
            </div>
                 <datatable
                    :columns="columns"
                    :sort-orders="sortOrders"
                    :sort-key="sortKey"
                >
                        <tbody class="">

                            <tr v-for="ticket in this.$page.props.consultations.data" :key="ticket.id">
                            <td class="border-b text-center">
                                <Link @click="show(ticket.id)">{{ ticket.id }}</Link>
                                <!-- <Link v-else @click="showAdmin(ticket.id)">{{ ticket.id }}</Link> -->
                            </td>
                            <td class="border-b text-center">{{ ticket.request_type }}</td>
                            <td class="border-b text-center">{{ ticket.consultation_date | formatDate }}</td>
                            <td class="border-b text-center">{{ ticket.reason }}</td>
                            <td class="border-b text-center">{{ ticket.status.name }}</td>
                            <td class="border-b text-center">{{ ticket.patient.profile[0].full_name }}</td>
                            </tr>
                        </tbody>
                    </datatable>
            </div>
            <!-- <div v-else class="flex justify-center"> <loader></loader> </div> -->
            <div class="container flex justify-between pb-5 px-5">
                <p>
                    Showing {{ pagination.from }} - {{ pagination.to }} of
                    {{ pagination.total }} entries
                </p>
                <paginate
                    :page-count="pagination.last_page"
                    v-model="currentPage"
                    :click-handler="changePage"
                    :prev-text="'Prev'"
                    :next-text="'Next'"
                    :container-class="'pagination justify-content-end'"
                    :page-class="'page-item'"
                    :page-link-class="'page-link'"
                    :prev-class="'page-item'"
                    :next-class="'page-item'"
                    :prev-link-class="'page-link'"
                    :next-link-class="'page-link'"
                    :active-class="'active'"
                >
                </paginate>
            </div>
    </div>
    </Navbar>
</template>
<script>
import Datatable from '@/components/partials/Datatable.vue'
import Navbar from '@/Layouts/TicketsLayout'
import Success from '@/Partials/Success.vue';
import Error from '@/Partials/Error.vue';
import { Link } from "@inertiajs/inertia-vue";
import Show from "@/Pages/Residents/Modals/ConsultationView.vue"
export default {
    name: "Documents",
    components: { Datatable, Navbar, Link, Success, Error },
    // created(){
    //     this.fetchDocuments();
    // },

    data(){
        let sortOrders = {};
        let columns = [
            { name: "id", label: "ID", class: "p-4", isSortable: false },
            { name: "request type", label: "Request Type", class: "p-4", isSortable: false },
            { name: "Consultation Date", label: "Consultation Date", class: "p-4", isSortable: false },
            { name: "Reason", label: "Reason", class: "p-4", isSortable: false },
            { name: "Status", label: "Status", class: "p-4", isSortable: false },
            { name: "Patient", label: "Patient", class: "p-4", isSortable: false },
        ];

        columns.forEach((column) => {
            sortOrders[column.name] = -1;
            });

        return {
            form: {
                selected: [],
            },
            tab: new URL(location.href).searchParams.get('tab'),
            columns: columns,
            sortOrders: sortOrders,
            sortKey: "id",
            dir: "asc",
            currentPage: this.$page.props.consultations.current_page,
            pagination: this.$page.props.consultations,
            // query: this.search ?? "",
            // page: this.$page.props.documents.current_page,
        };
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
                if(this.$page.props.auth.roles.includes('nurse') || this.$page.props.auth.roles.includes('doctor')){
                    return true;
                }else{
                    return false;
                }
            }
    },
    methods: {
        // sortBy(key) {
        // this.sortKey = key;
        // this.sortOrders[key] = this.sortOrders[key] * -1;
        // this.dir = this.sortOrders[key] == -1 ? "asc" : "desc";
        // this.fetch();
        // },

        // bookmark() {
        //     this.$inertia.post(route('bookmark.store'), this.form);
        // },

        // destroy() {
        //     this.$inertia.delete(`/document/bulkDelete`, this.form);
        // },

        ticket(){
            this.$modal.show(
                Create,
                {
                    id: this.form.id,
                },
                {
                    height: "auto",
                },
            )
        },

        show(id) {
            this.$modal.show(
                Show,
                {
                    id: id,
                },
                {
                    height: "auto",
                },
            )
        },

        showAdmin(id) {
            this.$modal.show(
                ShowAdmin,
                {
                    id: id,
                },
                {
                    height: "auto",
                },
            )
        },

        blotter() {

        },

        changePage(page) {
            this.currentPage = page;
            this.$inertia.get(route('clinic.index'), {
                // tab: this.tab,
                page: this.currentPage
            })
        },
    }
}
</script>
