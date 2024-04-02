<script>
import Menu from "../Components/Menu.vue";
export default {
    name: "People",
    components: {
        Menu,
    },
    props: {
        people: Array,
    },
    data() {
        return {
            isDialogOpen: false,
            formData: {
                name: "",
                birthday: "",
                cpf: "",
                sex: "",
                city: "",
                neighborhood: "",
                street: "",
                number: "",
                complement: "",
            },
        };
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
        async submitForm() {
            try {
                await this.$inertia.post("/people", this.formData);
                this.closeDialog();
            } catch (error) {
                console.error("Erro ao cadastrar pessoa:", error);
            }
        },
        closeDialog() {
            this.formData = {
                name: "",
                birthday: "",
                cpf: "",
                sex: "",
                city: "",
                neighborhood: "",
                street: "",
                number: "",
                complement: "",
            };
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
                                <v-card>
                                    <v-card-title class="text-h5 ma-4"
                                        >Cadastrar Pessoa</v-card-title
                                    >
                                    <v-card-text>
                                        <v-row>
                                            <v-col>
                                                <v-text-field
                                                    v-model="formData.name"
                                                    label="Nome"
                                                    variant="outlined"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col>
                                                <v-text-field
                                                    v-model="formData.birthday"
                                                    label="Data de Nascimento"
                                                    variant="outlined"
                                                    type="date"
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col>
                                                <v-text-field
                                                    v-model="formData.cpf"
                                                    label="CPF"
                                                    variant="outlined"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col>
                                                <v-select
                                                    v-model="formData.sex"
                                                    label="Sexo"
                                                    variant="outlined"
                                                    :items="[
                                                        'Masculino',
                                                        'Feminino',
                                                        'Outro',
                                                    ]"
                                                ></v-select>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col>
                                                <v-text-field
                                                    v-model="formData.city"
                                                    label="Cidade"
                                                    variant="outlined"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col>
                                                <v-text-field
                                                    v-model="
                                                        formData.neighborhood
                                                    "
                                                    label="Bairro"
                                                    variant="outlined"
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col>
                                                <v-text-field
                                                    v-model="formData.street"
                                                    label="Rua"
                                                    variant="outlined"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col>
                                                <v-text-field
                                                    v-model="formData.number"
                                                    label="Número"
                                                    variant="outlined"
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col>
                                                <v-text-field
                                                    v-model="
                                                        formData.complement
                                                    "
                                                    label="Complemento"
                                                    variant="outlined"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col>
                                                <v-card-actions
                                                    class="justify-end ga-6"
                                                >
                                                    <v-btn
                                                        rounded="xs"
                                                        color="grey"
                                                        size="large"
                                                        variant="tonal"
                                                        @click="
                                                            isDialogOpen = false
                                                        "
                                                        >Cancelar</v-btn
                                                    >
                                                    <v-btn
                                                        rounded="xs"
                                                        color="blue"
                                                        size="large"
                                                        variant="tonal"
                                                        @click="submitForm"
                                                        >Salvar</v-btn
                                                    >
                                                </v-card-actions>
                                            </v-col>
                                        </v-row>
                                    </v-card-text>
                                </v-card>
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
