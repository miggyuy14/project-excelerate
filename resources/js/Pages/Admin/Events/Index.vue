<template>
    <AdminLayout>
    <div class="px-5 bg-white">
        <Success :message="this.$page.props.flash.success"></Success>
        <Error :message="this.$page.props.flash.error"></Error>
        <div class="container-fluid items-center justify-center px-5">
            <div class="d-flex justify-content-between">
                <input class="shadow appearance-none border rounded py-2 px-3 mb-4 " id="search" type="text" placeholder="Search. . .">
            <!-- <div class="form-inline">
                <Link  class="btn btn-primary py-2 px-3 mr-2 mb-4" v-if="isResident" @click="create()">Create ticket</Link>
            </div> -->
            </div>
                 <datatable
                    :columns="columns"
                    :sort-orders="sortOrders"
                    :sort-key="sortKey"
                >
                        <tbody class="">

                            <tr v-for="data in this.$page.props.events.data" :key="data.id">
                            <td class="border-b text-center">
                                <!-- <Link>{{ ticket.id }}</Link> -->
                                <Link @click="showAdmin(data.id)">{{ data.id }}</Link>
                            </td>

                            <td class="border-b text-center">{{ data.description }}</td>
                            <td class="border-b text-center">{{ data.author.profile.full_name }}</td>
                            <td class="border-b text-center">
                                <button v-if="tab == 'events' && isStaff || isAdmin" @click="removeEvents(data.id)" class="btn btn-sm btn-danger">remove</button>
                            </td>

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
    </AdminLayout>
</template>
<script>
import Datatable from '@/components/partials/Datatable.vue'
import AdminLayout from '@/Layouts/AdminLayout'
import Success from '@/Partials/Success.vue';
import Error from '@/Partials/Error.vue';
import ShowAdmin from './Show.vue';
import { Link } from "@inertiajs/inertia-vue";
export default {
    name: "Documents",
    components: { Datatable, AdminLayout, Link, Success, Error, ShowAdmin },
    // created(){
    //     this.fetchDocuments();
    // },

    data(){
        let sortOrders = {};
        let columns = [
            { name: "id", label: "ID", class: "p-4", isSortable: false },
            { name: "Description", label: "Description", class: "p-4", isSortable: false },
            { name: "Author", label: "Author", class: "p-4", isSortable: false,
                isSmall: true },
            { name: "Actions", label: "Actions", class: "p-4", isSortable: false },
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
            currentPage: this.$page.props.events.current_page,
            pagination: this.$page.props.events,
            data: this.$page.props.events,

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

        showAdmin(id) {
            this.$modal.show(
                ShowAdmin,
                {
                    id: id,
                },
                {
                    height: "auto",
                    scrollable: true
                },
            )
        },

        removeEvents(){

        },

        changePage(page) {
            this.currentPage = page;
            this.$inertia.get(route('admin.users.view'), {
                // tab: this.tab,
                page: this.currentPage
            })
        },
    }
}
</script>
