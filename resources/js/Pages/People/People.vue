<script setup>
import Menu from "../../Components/Menu.vue";
import { defineProps, ref, computed } from "vue";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import { useForm } from "laravel-precognition-vue-inertia";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    people: Object,
});

const toast = useToast();
const deleteForm = ref();

const isDialogOpen = ref(false);
const person = ref(null);
const search = ref("");

const headers = [
    { title: "#", align: "left", value: "id" },
    { title: "Nome", value: "name" },
    { title: "CPF", value: "cpf" },
    { title: "Data de Nascimento", value: "birthday" },
    { title: "Sexo", value: "sex" },
    { title: "Ações", sortable: false },
];

const formatDate = (date) => {
    //date: yyyy-MM-dd
    const year = date.slice(0, 4);
    const mounth = date.slice(5, 7);
    const day = date.slice(8, 10);
    return day + "/" + mounth + "/" + year;
};

const formatCpf = (cpf) => {
    const part1 = cpf.slice(0, 3);
    const part2 = cpf.slice(3, 6);
    const part3 = cpf.slice(6, 9);
    const part4 = cpf.slice(9, 11);
    return part1 + "." + part2 + "." + part3 + "-" + part4;
};

const openDelete = (item) => {
    isDialogOpen.value = true;
    person.value = item;
    deleteForm.value = useForm("delete", `/pessoas/pessoa-${item.id}`, {
        id: item.id,
    });
};

const deleteItem = () => {
    deleteForm.value.submit({
        preserveScroll: true,
        onSuccess: () => {
            toast.success("Pessoa excluída com sucesso!", {
                position: "top-right",
            });
            isDialogOpen.value = false;
        },
        onError: () => {
            toast.error("Erro ao excluir pessoa!", {
                position: "top-right",
            });
        },
    });
};

//pagination
const itemsPerPage = ref(10);
const page = ref(1);
const pageCount = computed(() => {
    return Math.ceil(props.people.length / itemsPerPage.value);
});
</script>

<template>
    <v-app>
        <Menu />
        <v-main class="bg-grey-lighten-4">
            <v-container>
                <span>Atende Cidadão > Pessoas</span>
                <v-card class="mt-8 pa-8">
                    <div class="d-flex align-center justify-space-between">
                        <v-card-title class="text-h5 my-8 pa-0"
                            >Pessoas</v-card-title
                        >
                        <v-card-title class="pa-0">
                            <Link
                                rounded="xs"
                                color="blue"
                                variant="tonal"
                                :href="route('people.create')"
                                class="text-light-blue-darken-2 bg-light-blue-lighten-5 pa-4"
                                >CADASTRAR</Link
                            >
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
                        :items="people"
                        :items-per-page="itemsPerPage"
                        :search="search"
                    >
                        <template v-slot:item="{ item }">
                            <tr>
                                <td>{{ item.id }}</td>
                                <td>{{ item.name }}</td>
                                <td>{{ formatCpf(item.cpf) }}</td>
                                <td>{{ formatDate(item.birthday) }}</td>
                                <td>{{ item.sex }}</td>
                                <td class="d-flex align-center ga-2">
                                    <v-btn
                                        :href="route('people.show', item.id)"
                                        rounded="xs"
                                        color="light-blue-lighten-5"
                                        prepend-icon="mdi-pencil"
                                        size="small"
                                        class="text-light-blue-darken-2"
                                        variant="tonal"
                                    >
                                        VISUALIZAR
                                    </v-btn>
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
                    >Tem certeza que deseja deletar
                    <strong>{{ person.name }}</strong
                    >?</v-card-text
                >
                <v-card-actions class="ga-6">
                    <v-btn
                        :href="route('people.index')"
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
