<script setup>
import Menu from "../../Components/Menu.vue";
import { defineProps, ref, computed } from "vue";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    users: Object,
});

const search = ref("");

const headers = [
    { title: "#", align: "left", value: "id" },
    { title: "Nome", value: "name" },
    { title: "E-mail", value: "email" },
    { title: "Perfil", value: "profile" },
    { title: "Status", value: "active" },
    { title: "Ações", sortable: false },
];

//pagination
const itemsPerPage = ref(10);
const page = ref(1);
const pageCount = computed(() => {
    return Math.ceil(props.users.length / itemsPerPage.value);
});

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
</script>

<template>
    <v-app>
        <Menu />
        <v-main class="bg-grey-lighten-4 mt-8">
            <v-container>
                <span>Atende Cidadão > Usuários</span>
                <v-card class="mt-8 pa-8">
                    <div class="d-flex align-center justify-space-between">
                        <v-card-title class="text-h5 my-8 pa-0"
                            >Usuários</v-card-title
                        >
                        <v-card-title class="pa-2">
                            <Link
                                color="blue"
                                :href="route('user.create')"
                                class="text-light-blue-darken-2 text-button bg-light-blue-lighten-5 pa-4 rounded-lg"
                                >REGISTRAR</Link
                            >
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
                        :items="users"
                        :items-per-page="itemsPerPage"
                        :search="search"
                    >
                        <template v-slot:item="{ item }">
                            <tr>
                                <td>{{ item.id }}</td>
                                <td>{{ item.name }}</td>
                                <td>{{ item.email }}</td>
                                <td>{{ showProfile(item.profile) }}</td>
                                <td>{{ showStatus(item.active) }}</td>
                                <td class="d-flex align-center ga-2">
                                    <v-btn
                                        :href="route('user.edit', item.id)"
                                        rounded="xs"
                                        color="light-blue-lighten-5"
                                        prepend-icon="mdi-pencil"
                                        size="small"
                                        class="text-light-blue-darken-2"
                                        variant="tonal"
                                    >
                                        VISUALIZAR
                                    </v-btn>
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
