<script>
import Menu from "../Components/Menu.vue";
export default {
    name: "People",
    components: {
        Menu,
    },
};
</script>

<template>
    <v-app>
        <Menu />
        <v-main>
            <v-container>
                <span>Atende Cidadão > Pessoas</span>
                <h1 class="mt-6">PEOPLE TABLE HERE</h1>
            </v-container>
        </v-main>
    </v-app>
</template>
