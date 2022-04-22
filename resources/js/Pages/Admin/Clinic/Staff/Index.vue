<template>
    <ClinicLayout>
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

                            <tr v-for="data in this.$page.props.data" :key="data.id">
                            <td class="border-b text-center">
                                <Link>{{ data.id }}</Link>
                                <!-- <Link @click="showAdmin(data.id)">{{ data.id }}</Link> -->
                            </td>
                            <td class="border-b text-center">{{ data.profile.full_name }}</td>
                            <td class="border-b text-center">{{ data.profile.address }}</td>
                            <td class="border-b text-center">Zone {{ data.profile.zone_id }}</td>
                            <td class="border-b text-center">{{ data.profile.occupation }}</td>
                            <td class="border-b text-center">{{ data.profile.gender }}</td>
                            <td class="border-b text-center">{{ data.profile.created_at | formatDate }}</td>
                            <td class="border-b text-center">
                                <!-- <button v-if="data.active == 0 || data.active == 2 && data.user_roles.includes('resident')" class="btn btn-sm btn-primary" @click="approve(data.id)">Activate</button>
                                <button v-if="data.active == 1 && data.user_roles.includes('resident')" class="btn btn-sm btn-danger" @click="deactivate(data.id)">Deactivate</button> -->
                                <button v-if="tab == 'nurse' && data.user_roles.includes('nurse') || data.user_roles.includes('doctor')" @click="removeOfficial(data.id)" class="btn btn-sm btn-danger">remove</button>
                                <!-- <button v-if="tab == 'leader' && data.user_roles.includes('staff') || data.user_roles.includes('zone_leader')" @click="removeOfficial(data.id)" class="btn btn-sm btn-danger">remove</button> -->
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
    </ClinicLayout>
</template>
<script>
import Datatable from '@/components/partials/Datatable.vue'
import ClinicLayout from '@/Layouts/ClinicLayout'
import Success from '@/Partials/Success.vue';
import Error from '@/Partials/Error.vue';
// import ShowAdmin from './Show.vue';
import { Link } from "@inertiajs/inertia-vue";
export default {
    name: "Documents",
    components: { Datatable, ClinicLayout, Link, Success, Error },
    // created(){
    //     this.fetchDocuments();
    // },

    data(){
        let sortOrders = {};
        let columns = [
            { name: "id", label: "ID", class: "p-4", isSortable: false },
            { name: "Name", label: "Name", class: "p-4", isSortable: false },
            { name: "Address", label: "Address", class: "p-4", isSortable: false,
                isSmall: true },
            { name: "Zone ID", label: "Zone ID", class: "p-4", isSortable: false,
                isSmall: true },
            { name: "Occupation", label: "Occupation", class: "p-4", isSortable: false },
            { name: "Gender", label: "Gender", class: "p-4", isSortable: false },
            { name: "Created at", label: "Created at", class: "p-4", isSortable: false },
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
            currentPage: this.$page.props.data.current_page,
            pagination: this.$page.props.data,
            data: this.$page.props.data,

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

        approve(id) {
            this.$swal({
                title: 'Are you sure?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes Approve it!',
                cancelButtonText: 'No, Not now!',
                showCloseButton: true,
                showLoaderOnConfirm: true
                }).then((result) => {
                if(result.value) {
                    this.$inertia.put(`/admin/user/approve/${id}`)
                    this.$swal('Approved', 'You successfully approved this resident', 'success')
                } else {
                    this.$swal('Cancelled', "The resident's access is still pending", 'info')
                }
                });

        },
        deactivate(id) {
            this.$swal({
                title: 'Are you sure?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes Deactivate!',
                cancelButtonText: 'No, Not now!',
                showCloseButton: true,
                showLoaderOnConfirm: true
                }).then((result) => {
                if(result.value) {
                    this.$inertia.put(`/admin/user/deactivate/${id}`)
                    this.$swal('Rejected', 'You successfully deactivated this resident', 'success')
                } else {
                    this.$swal('Cancelled', "The resident's access is still active", 'info')
                }
                });

        },

        removeOfficial(id) {
            this.$swal({
                title: 'Are you sure?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes Remove!',
                cancelButtonText: 'No, Not now!',
                showCloseButton: true,
                showLoaderOnConfirm: true
                }).then((result) => {
                if(result.value) {
                    this.$inertia.put(route('admin.official.remove', id))
                    this.$swal('Rejected', 'You successfully deactivated this resident', 'success')
                } else {
                    this.$swal('Cancelled', "The resident's access is still active", 'info')
                }
                });

        },

        removeLeader(id) {
            this.$swal({
                title: 'Are you sure?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes Remove!',
                cancelButtonText: 'No, Not now!',
                showCloseButton: true,
                showLoaderOnConfirm: true
                }).then((result) => {
                if(result.value) {
                    this.$inertia.put(route('admin.leader.remove', id))
                    this.$swal('Rejected', 'You successfully deactivated this resident', 'success')
                } else {
                    this.$swal('Cancelled', "The resident's access is still active", 'info')
                }
                });

        },

        // showAdmin(id) {
        //     this.$modal.show(
        //         ShowAdmin,
        //         {
        //             id: id,
        //         },
        //         {
        //             height: "450px",
        //         },
        //     )
        // },

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
