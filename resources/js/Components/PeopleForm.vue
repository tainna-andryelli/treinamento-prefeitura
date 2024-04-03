<script>
export default {
    name: "PeopleForm",
    emits: ["closeDialog"],
    data() {
        return {
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
        async submitForm() {
            try {
                await this.$inertia.post("/people", this.formData);
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
                this.$emit("closeDialog");
            } catch (error) {
                console.error("Erro ao cadastrar pessoa:", error);
            }
        },
    },
};
</script>

<template>
    <v-card>
        <v-card-title class="text-h5 ma-4">Cadastrar Pessoa</v-card-title>
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
                        :items="['Masculino', 'Feminino', 'Outro']"
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
                        v-model="formData.neighborhood"
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
                        v-model="formData.complement"
                        label="Complemento"
                        variant="outlined"
                    ></v-text-field>
                </v-col>
                <v-col>
                    <v-card-actions class="justify-end ga-6">
                        <v-btn
                            rounded="xs"
                            color="grey"
                            size="large"
                            variant="tonal"
                            @click="$emit('closeDialog')"
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
</template>
