<script>
import Menu from "../Components/Menu.vue";
import Pagination from "../Components/Pagination.vue";
import PeopleForm from "../Components/PeopleForm.vue";

export default {
    name: "People",
    data() {
        return {
            isDialogOpen: false,
            isEditing: false,
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
        };
    },
    components: {
        Menu,
        PeopleForm,
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
        redirect(route) {
            window.location.href = route;
        },
        openDialog(mode, item = null) {
            this.isDialogOpen = true;
            this.isEditing = mode === "edit";
            this.person = item;
        },
        closeDialog() {
            this.isDialogOpen = false;
        },
        deleteItem(item) {
            console.log("Deleta o item: ", item);
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
                <v-card class="mt-8">
                    <div class="d-flex align-center justify-space-between">
                        <v-card-title class="text-h5 my-4"
                            >Pessoas</v-card-title
                        >
                        <v-card-title>
                            <v-btn
                                rounded="xs"
                                color="blue"
                                variant="tonal"
                                @click="openDialog()"
                                >CADASTRAR</v-btn
                            >
                            <v-dialog v-model="isDialogOpen" width="1000px">
                                <PeopleForm
                                    @closeDialog="closeDialog"
                                    :isEditing="isEditing"
                                    :item="{}"
                                />
                            </v-dialog>
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
                                        @click="openDialog('edit', item)"
                                        rounded="xs"
                                        color="light-blue-lighten-5"
                                        prepend-icon="mdi-pencil"
                                        size="small"
                                        class="text-light-blue-darken-2"
                                        variant="tonal"
                                    >
                                        VISUALIZAR
                                    </v-btn>
                                    <v-dialog
                                        v-model="isDialogOpen"
                                        width="1000px"
                                    >
                                        <PeopleForm
                                            @closeDialog="closeDialog"
                                            :item="person"
                                            :isEditing="isEditing"
                                        />
                                    </v-dialog>
                                    <v-btn
                                        @click="deleteItem(item)"
                                        rounded="xs"
                                        color="light-blue-lighten-5"
                                        prepend-icon="mdi-pencil"
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
    </v-app>
</template>

<style>
.v-data-table-footer {
    display: none;
}
.v-overlay__scrim {
    background-color: transparent;
    backdrop-filter: blur(0.6px);
}

.v-dialog > .v-overlay__content > .v-card {
    box-shadow: none;
    overflow-y: hidden;
    border: solid 0.5px grey;
}
</style>
