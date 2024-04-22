<script setup>
import Menu from "../../Components/Menu.vue";
import { defineProps, ref, computed } from "vue";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import { useForm } from "laravel-precognition-vue-inertia";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    protocols: Object,
    people: Object,
});

const toast = useToast();
const deleteForm = ref();

const isDialogOpen = ref(false);
const protocol = ref(null);
const search = ref("");

const headers = [
    { title: "Número", align: "left", value: "number" },
    { title: "Descrição", value: "description" },
    { title: "Data de Criação", value: "create_date" },
    { title: "Prazo (em dias)", value: "deadline_days" },
    { title: "Contribuinte", value: "contributor_id" },
    { title: "Ações", sortable: false },
];

const getNameContributor = (personId) => {
    const contributor = props.people.find((person) => person.id === personId);
    return contributor ? contributor.name : "Nome não encontrado";
};

const openDelete = (item) => {
    isDialogOpen.value = true;
    protocol.value = item;
    deleteForm.value = useForm(
        "delete",
        `/protocolos/protocolo-${item.number}`,
        {
            number: item.number,
        }
    );
};

const deleteItem = () => {
    deleteForm.value.submit({
        preserveScroll: true,
        onSuccess: () => {
            toast.success("Protocolo excluído com sucesso!", {
                position: "top-right",
            });
            isDialogOpen.value = false;
        },
        onError: () => {
            toast.error("Erro ao excluir protocolo!", {
                position: "top-right",
            });
        },
    });
};

//pagination
const itemsPerPage = ref(10);
const page = ref(1);
const pageCount = computed(() => {
    return Math.ceil(props.protocols.length / itemsPerPage.value);
});
</script>

<template>
    <v-app>
        <Menu />
        <v-main class="bg-grey-lighten-4 mt-8">
            <v-container>
                <span>Atende Cidadão > Protocolos</span>
                <v-card class="mt-8 pa-8">
                    <div class="d-flex align-center justify-space-between">
                        <v-card-title class="text-h4 my-8 pa-0"
                            >Protocolos</v-card-title
                        >
                        <v-card-title class="pa-2">
                            <Link :href="route('protocols.create')">
                                <v-btn
                                    rounded="xs"
                                    color="light-blue-lighten-5"
                                    size="large"
                                    class="text-light-blue-darken-2"
                                    variant="tonal"
                                >
                                    Cadastrar
                                </v-btn>
                            </Link>
                        </v-card-title>
                    </div>
                    <v-card-title class="pa-0 mb-8">
                        <v-text-field
                            v-model="search"
                            label="Buscar Pessoa"
                            prepend-inner-icon="mdi-magnify"
                            single-line
                            variant="outlined"
                            hide-details
                        />
                    </v-card-title>
                    <v-data-table
                        v-model:page="page"
                        :headers="headers"
                        :items="protocols"
                        :items-per-page="itemsPerPage"
                        :search="search"
                    >
                        <template v-slot:item="{ item }">
                            <tr>
                                <td>{{ item.number }}</td>
                                <td>{{ item.description }}</td>
                                <td>{{ item.created_date }}</td>
                                <td>{{ item.deadline_days }}</td>
                                <td>
                                    {{
                                        getNameContributor(item.contributor_id)
                                    }}
                                </td>
                                <td class="d-flex align-center ga-2">
                                    <Link
                                        :href="
                                            route('protocols.edit', item.number)
                                        "
                                    >
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
                                    <v-btn
                                        @click="openDelete(item)"
                                        rounded="xs"
                                        color="light-blue-lighten-5"
                                        prepend-icon="mdi-delete"
                                        size="small"
                                        class="text-light-blue-darken-2"
                                        variant="tonal"
                                    >
                                        EXCLUIR
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

        <v-dialog v-model="isDialogOpen" width="500px">
            <v-card class="d-flex ga-4 pa-8 bg-red-lighten-1">
                <v-card-title class="text-h4">Deletar Pessoa</v-card-title>
                <v-card-text class="pa-4"
                    >Tem certeza que deseja deletar o protocolo de número
                    {{ protocol.number }}?</v-card-text
                >
                <v-card-actions class="ga-6">
                    <v-btn
                        @click="isDialogOpen = false"
                        rounded="xs"
                        color="white"
                        size="large"
                        variant="tonal"
                        >Cancelar</v-btn
                    >
                    <v-btn
                        rounded="xs"
                        color="black"
                        size="large"
                        variant="tonal"
                        @click="deleteItem"
                        >Confirmar</v-btn
                    >
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-app>
</template>

<style>
.v-data-table-footer {
    display: none;
}
</style>
