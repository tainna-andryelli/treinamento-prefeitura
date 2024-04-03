<script>
import Menu from "../Components/Menu.vue";
import PeopleForm from "../Components/PeopleForm.vue";

export default {
    name: "People",
    data() {
        return {
            isDialogOpen: false,
        };
    },
    components: {
        Menu,
        PeopleForm,
    },
    props: {
        people: Array,
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
        closeDialog() {
            this.isDialogOpen = false;
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
                                @click="isDialogOpen = true"
                                >CADASTRAR</v-btn
                            >
                            <v-dialog v-model="isDialogOpen" width="1000px">
                                <PeopleForm @closeDialog="closeDialog" />
                            </v-dialog>
                        </v-card-title>
                    </div>
                    <v-table>
                        <thead class="bg-grey-lighten-3">
                            <tr>
                                <th class="font-weight-bold text-subtitle-2">
                                    #
                                </th>
                                <th class="font-weight-bold text-subtitle-2">
                                    Nome
                                </th>
                                <th class="font-weight-bold text-subtitle-2">
                                    CPF
                                </th>
                                <th class="font-weight-bold text-subtitle-2">
                                    Data de Nascimento
                                </th>
                                <th class="font-weight-bold text-subtitle-2">
                                    Sexo
                                </th>
                                <th class="font-weight-bold text-subtitle-2">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="person in people" :key="person.id">
                                <td>{{ person.id }}</td>
                                <td>{{ person.name }}</td>
                                <td>{{ person.cpf }}</td>
                                <td>{{ formatDate(person.birthday) }}</td>
                                <td>{{ person.sex }}</td>
                                <td class="d-flex align-center ga-2">
                                    <v-btn
                                        rounded="xs"
                                        color="light-blue-lighten-5"
                                        prepend-icon="mdi-pencil"
                                        size="small"
                                        class="text-light-blue-darken-2"
                                        variant="tonal"
                                        >VISUALIZAR</v-btn
                                    >
                                    <v-btn
                                        rounded="xs"
                                        color="light-blue-lighten-5"
                                        prepend-icon="mdi-pencil"
                                        size="small"
                                        class="text-light-blue-darken-2"
                                        variant="tonal"
                                        >EXCLUIR</v-btn
                                    >
                                </td>
                            </tr>
                        </tbody>
                    </v-table>
                </v-card>
            </v-container>
        </v-main>
    </v-app>
</template>
