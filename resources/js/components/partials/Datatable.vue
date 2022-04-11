<template>
    <table class="table table-sm table-hover table__custom">
                <thead class="text-left">
            <tr>
                <th scope="col" v-for="(column, index) in columns"
                    :key="column.name"
                    :class="(columns[index]['isSmall']) ? 'w-1/8 px-4' : 'w-1/4 px-4'"
                    @click="$emit('sort', column.name)">

                    {{column.label}}

                    <i class="fas"
                        :class="column.isSortable == true ? (sortKey == column.name ? (sortOrders[column.name] > 0 ? 'fa-sort-up' : 'fa-sort-down') : 'fa-sort' ) : ''"></i>
                </th>
            </tr>
        </thead>

        <slot></slot>

    </table>
</template>

<script>
export default {
    props: ["columns", "sortOrders", "sortKey"],
};
</script>
