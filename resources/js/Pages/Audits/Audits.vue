<script setup>
import Menu from "../../Components/Menu.vue";
import { defineProps, ref, computed } from "vue";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import { useForm } from "laravel-precognition-vue-inertia";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    audits: Object,
    users: Object,
});

const toast = useToast();
const search = ref("");

const headers = [
    { title: "ID", align: "left", value: "id" },
    { title: "Usuário", value: "user_id" },
    { title: "Evento", value: "event" },
    { title: "Data e Hora de Criação", value: "created_at" },
    { title: "Tabela", value: "auditable_type" },
    { title: "ID Auditado", value: "auditable_id" },
    { title: "Ações", sortable: false },
];

const getUserName = (userId) => {
    const user = props.users.find((user) => user.id === userId);
    return user ? user.name : "Nome não encontrado";
};

const showEvent = (event) => {
    if (event === "created") {
        return "Criação";
    } else if (event === "updated") {
        return "Alteração";
    } else if (event === "deleted") {
        return "Exclusão";
    } else if (event === "restored") {
        return restaurado;
    } else if (event === "forceDeleted") {
        return "Permanentemente excluído";
    }
    return "Não encontrado";
};

const formatCreatedAt = (created_at) => {
    const date = new Date(created_at);
    const formattedDate = `${date.toLocaleDateString()} ${date.toLocaleTimeString()}`;

    return formattedDate;
};

const getTableName = (auditableType) => {
    const parts = auditableType.split("\\");
    const tableName = parts[parts.length - 1];
    return tableName;
};

//pagination
const itemsPerPage = ref(10);
const page = ref(1);
const pageCount = computed(() => {
    return Math.ceil(props.audits.length / itemsPerPage.value);
});
</script>

<template>
    <v-app>
        <Menu />
        <v-main class="bg-grey-lighten-4 mt-8">
            <v-container>
                <span>Atende Cidadão > Auditoria</span>
                <v-card class="mt-8 pa-8">
                    <div class="d-flex align-center justify-space-between">
                        <v-card-title class="text-h4 my-8 pa-0"
                            >Auditoria</v-card-title
                        >
                    </div>
                    <v-card-title class="pa-0 mb-8">
                        <v-text-field
                            v-model="search"
                            label="Pesquisar"
                            prepend-inner-icon="mdi-magnify"
                            single-line
                            variant="outlined"
                            hide-details
                        />
                    </v-card-title>
                    <v-data-table
                        v-model:page="page"
                        :headers="headers"
                        :items="audits"
                        :items-per-page="itemsPerPage"
                        :search="search"
                        class="mb-8"
                    >
                        <template v-slot:item="{ item }">
                            <tr>
                                <td>{{ item.id }}</td>
                                <td>{{ getUserName(item.user_id) }}</td>
                                <td>{{ showEvent(item.event) }}</td>
                                <td>{{ formatCreatedAt(item.created_at) }}</td>
                                <td>{{ getTableName(item.auditable_type) }}</td>
                                <td>{{ item.auditable_id }}</td>
                                <td class="d-flex align-center ga-2">
                                    <Link
                                        :href="
                                            route('audits.show', {
                                                id: item.id,
                                            })
                                        "
                                    >
                                        <v-btn
                                            rounded="xs"
                                            color="light-blue-lighten-5"
                                            size="small"
                                            class="text-light-blue-darken-2"
                                            variant="tonal"
                                        >
                                            Detalhes
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
