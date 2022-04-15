<template>
    <Navbar>
    <div class="px-5 bg-white">
        <Success :message="this.$page.props.flash.success"></Success>
        <Error :message="this.$page.props.flash.error"></Error>
        <div class="container-fluid items-center justify-center px-5">
            <h2>Requests</h2>
            <div class="d-flex justify-content-between">
                <input class="shadow appearance-none border rounded py-2 px-3 mb-4 " id="search" type="text" placeholder="Search. . .">
            <div class="form-inline">
                <Link  class="btn btn-primary py-2 px-3 mr-2 mb-4" @click="ticket()">Create ticket</Link>
                <Link  class="btn btn-primary py-2 px-3 mr-2 mb-4" @click="consultation()">Create consultation</Link>
            </div>
            </div>
                 <datatable
                    :columns="columns"
                    :sort-orders="sortOrders"
                    :sort-key="sortKey"
                >
                        <tbody class="">

                            <tr v-for="ticket in this.$page.props.tickets.data" :key="ticket.id">
                            <td class="border-b text-center">
                                <Link v-if="isResident" @click="show(ticket.id)">{{ ticket.id }}</Link>
                                <Link v-else @click="showAdmin(ticket.id)">{{ ticket.id }}</Link>
                            </td>
                            <td class="border-b text-center">{{ ticket.request_type }}</td>
                            <td class="border-b text-center">{{ ticket.description }}</td>
                            <td class="border-b text-center">Zone {{ ticket.zone_id }}</td>
                            <td class="border-b text-center">{{ ticket.or_no }}</td>
                            <td class="border-b text-center">{{ ticket.amount }}</td>
                            <td class="border-b text-center">{{ ticket.status.name }}</td>
                            <td class="border-b text-center">{{ ticket.requestor.profile.full_name }}</td>
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
import Navbar from '@/Layouts/TrueNavbar'
import Success from '@/Partials/Success.vue';
import Error from '@/Partials/Error.vue';
import { Link } from "@inertiajs/inertia-vue";
import Create from './Residents/Modals/Create.vue';
import ShowAdmin from './ZoneLeader/Modals/Show.vue';
import ConsultationVue from './Residents/Modals/Consultation.vue';
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
            { name: "Description", label: "Description", class: "p-4", isSortable: false,
                isSmall: true },
            { name: "Zone ID", label: "Zone ID", class: "p-4", isSortable: false,
                isSmall: true },
            { name: "OR No", label: "OR No", class: "p-4", isSortable: false },
            { name: "Amount", label: "Amount", class: "p-4", isSortable: false },
            { name: "Status", label: "Status", class: "p-4", isSortable: false },
            { name: "owner", label: "Owner", class: "p-4", isSortable: false },
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
            currentPage: this.$page.props.tickets.current_page,
            pagination: this.$page.props.tickets,
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

        consultation(){
            this.$modal.show(
                ConsultationVue,
                {
                    id: this.form.id,
                },
                {
                    height: "auto",
                },
            )
        },

        show() {
            this.$modal.show(
                Show,
                {
                    id: this.$page.props.tickets.data.id,
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
            this.$inertia.get(route('tickets.index'), {
                // tab: this.tab,
                page: this.currentPage
            })
        },
    }
}
</script>
