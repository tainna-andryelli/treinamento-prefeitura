<script setup>
import Menu from "../../Components/Menu.vue";
import { defineProps, ref, computed } from "vue";
import "vue-toast-notification/dist/theme-sugar.css";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    users: Object,
    userAuth: Object,
});

const headers = [
    { title: "#", align: "left", value: "id" },
    { title: "Nome", value: "name" },
    { title: "E-mail", value: "email" },
    { title: "Perfil", value: "profile" },
    { title: "Status", value: "active" },
];

if (props.userAuth.profile !== "A") {
    headers.push({ title: "Ações", sortable: false });
}

const showProfile = (profile) => {
    if (profile === "T") {
        return "Administrador da TI";
    } else if (profile === "S") {
        return "Administrador do Sistema";
    }

    return "Atendente";
};

const showStatus = (status) => {
    if (status === "S") {
        return "Ativo";
    }
    return "Desativado";
};

//Search
const search = ref("");
const filteredUsers = computed(() => {
    if (!search.value) return props.users;

    const searchTerm = search.value.toLowerCase();

    return props.users.filter((user) => {
        return (
            user.id.toString().includes(searchTerm) ||
            user.name.toLowerCase().includes(searchTerm) ||
            user.email.toLowerCase().includes(searchTerm) ||
            showProfile(user.profile).toLowerCase().includes(searchTerm) ||
            showStatus(user.active).toLowerCase().includes(searchTerm)
        );
    });
});

//pagination
const itemsPerPage = ref(10);
const page = ref(1);
const pageCount = computed(() => {
    return Math.ceil(props.users.length / itemsPerPage.value);
});
</script>

<template>
    <v-app>
        <Menu />
        <v-main class="bg-grey-lighten-4 mt-8">
            <v-container>
                <span>Atende Cidadão > Usuários</span>
                <v-card class="mt-8 pa-8">
                    <div class="d-flex align-center justify-space-between">
                        <v-card-title class="text-h4 my-8 pa-0"
                            >Usuários</v-card-title
                        >
                        <v-card-title class="pa-2">
                            <template
                                v-if="userAuth && userAuth.profile !== 'A'"
                            >
                                <Link :href="route('user.create')">
                                    <v-btn
                                        rounded="xs"
                                        color="light-blue-lighten-5"
                                        size="large"
                                        class="text-light-blue-darken-2"
                                        variant="tonal"
                                    >
                                        Registrar
                                    </v-btn>
                                </Link>
                            </template>
                        </v-card-title>
                    </div>
                    <v-card-title class="pa-0 mb-8">
                        <v-text-field
                            v-model="search"
                            label="Buscar Usuário"
                            prepend-inner-icon="mdi-magnify"
                            single-line
                            variant="outlined"
                            hide-details
                        />
                    </v-card-title>
                    <v-data-table
                        v-model:page="page"
                        :headers="headers"
                        :items="filteredUsers"
                        :items-per-page="itemsPerPage"
                    >
                        <template v-slot:item="{ item }">
                            <tr>
                                <td>{{ item.id }}</td>
                                <td>{{ item.name }}</td>
                                <td>{{ item.email }}</td>
                                <td>{{ showProfile(item.profile) }}</td>
                                <td>{{ showStatus(item.active) }}</td>
                                <td
                                    v-if="userAuth.profile !== 'A'"
                                    class="d-flex align-center ga-2"
                                >
                                    <Link :href="route('user.edit', item.id)">
                                        <v-btn
                                            rounded="xs"
                                            color="light-blue-lighten-5"
                                            prepend-icon="mdi-pencil"
                                            size="small"
                                            class="text-light-blue-darken-2"
                                            variant="tonal"
                                        >
                                            VISUALIZAR
                                        </v-btn>
                                    </Link>
                                </td>
                            </tr>
                        </template>
                    </v-data-table>
                    <v-pagination
                        v-model="page"
                        :length="pageCount"
                        class="text-light-blue-darken-2 mt-8"
                    ></v-pagination>
                </v-card>
            </v-container>
        </v-main>
    </v-app>
</template>

<style>
.v-data-table-footer {
    display: none;
}
</style>
