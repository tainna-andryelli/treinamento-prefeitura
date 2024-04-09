<script>
import Menu from "../../Components/Menu.vue";
import Pagination from "../../Components/Pagination.vue";
import { useToast } from "vue-toast-notification";

export default {
    name: "People",
    data() {
        return {
            isDialogOpen: false,
            person: null,
            perPage: 10, //numero de itens por page
            page: 1, //page atual
            headers: [
                { title: "#", align: "left", value: "id" },
                { title: "Nome", value: "name" },
                { title: "CPF", value: "cpf" },
                { title: "Data de Nascimento", value: "birthday" },
                { title: "Sexo", value: "sex" },
                { title: "Ações", sortable: false },
            ],
            toast: useToast(),
        };
    },
    components: {
        Menu,
        Pagination,
    },
    props: {
        people: Object,
    },
    computed: {
        totalPages() {
            return this.people.last_page;
        },
    },
    methods: {
        formatDate(date) {
            //date: yyyy-MM-dd
            const year = date.slice(0, 4);
            const mounth = date.slice(5, 7);
            const day = date.slice(8, 10);
            return day + "/" + mounth + "/" + year;
        },
        formatCpf(cpf) {
            const part1 = cpf.slice(0, 3);
            const part2 = cpf.slice(3, 6);
            const part3 = cpf.slice(6, 9);
            const part4 = cpf.slice(9, 11);
            return part1 + "." + part2 + "." + part3 + "-" + part4;
        },
        openDelete(item) {
            this.isDialogOpen = true;
            this.person = item;
        },
        async deleteItem() {
            try {
                await this.$inertia.delete(`/people/${this.person.id}`);
                this.toast.success("Pessoa deletada com sucesso!", {
                    position: "top-right",
                });
                this.isDialogOpen = false;
                onSucess: () => {};
            } catch (error) {
                this.toast.error("Erro ao deletar pessoa!", {
                    position: "top-right",
                });
            }
        },
    },
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
                    <Pagination :page="page" :totalPages="totalPages" />
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
.v-overlay__scrim {
    background-color: transparent;
    backdrop-filter: blur(2px);
}

.v-dialog > .v-overlay__content > .v-card {
    box-shadow: none;
    overflow-y: hidden;
    border: solid 0.5px grey;
}
</style>
