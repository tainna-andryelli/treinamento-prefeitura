<script>
import Menu from "../Components/Menu.vue";
export default {
    name: "Users",
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
                <span>Atende Cidadão > Usuários</span>
                <h1 class="mt-6">USERS CONTENT HERE</h1>
            </v-container>
        </v-main>
    </v-app>
</template>
