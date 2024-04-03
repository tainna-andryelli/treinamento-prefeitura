<template>
    <v-app>
        <v-pagination
            v-bind="page"
            :length="totalPages"
            color="primary"
            next-icon="mdi-menu-right"
            prev-icon="mdi-menu-left"
        ></v-pagination>
    </v-app>
</template>

<script>
export default {
    name: "Pagination",
    props: {
        page: Number,
        totalPages: Number,
    },
    computed: {},
};
</script>
