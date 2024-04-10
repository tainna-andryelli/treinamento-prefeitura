<script setup>
import Menu from "../../Components/Menu.vue";
import { defineProps, ref } from "vue";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import { useForm } from "laravel-precognition-vue-inertia";

const props = defineProps({
    people: Object,
});
const toast = useToast();
const deleteForm = ref();

const isDialogOpen = ref(false);
const person = ref(null);
const perPage = ref(10);
const page = ref(1);

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

const openDelete = (item) => {
    isDialogOpen.value = true;
    person.value = item;
    deleteForm.value = useForm("delete", `/people/${item.id}`, {
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
</script>

<template>
    <v-app>
        <Menu />
        <v-main class="bg-grey-lighten-4">
            <v-container>
                <span>Atende Cidadão > Pessoas</span>
                <v-card class="mt-8 pa-8">
                    <div class="d-flex align-center justify-space-between">
                        <v-card-title class="text-h5 my-8"
                            >Pessoas</v-card-title
                        >
                        <v-card-title>
                            <v-btn
                                rounded="xs"
                                color="blue"
                                variant="tonal"
                                :href="route('people.create')"
                                >CADASTRAR</v-btn
                            >
                        </v-card-title>
                    </div>
                    <v-data-table
                        :headers="headers"
                        :items="people.data"
                        :items-per-page="perPage"
                        :page="page"
                    >
                        <template v-slot:item="{ item }">
                            <tr>
                                <td>{{ item.id }}</td>
                                <td>{{ item.name }}</td>
                                <td>{{ item.cpf }}</td>
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
                    <!-- pagination here -->
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