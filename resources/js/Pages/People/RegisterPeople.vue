<script setup>
import { useForm } from "laravel-precognition-vue-inertia";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import Menu from "../../Components/Menu.vue";
import { Link } from "@inertiajs/vue3";
import { defineProps } from "vue";

const props = defineProps({
    userProfile: String,
});

const form = useForm("post", route("people.store"), {
    name: "",
    birthday: "",
    cpf: "",
    sex: "",
    city: "",
    neighborhood: "",
    street: "",
    number: "",
    complement: "",
});

const toast = useToast();

const submit = () => {
    form.cpf = form.cpf.replace(/\D/g, ""); //remove the mask
    form.submit({
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            toast.success("Pessoa cadastrada com sucesso!", {
                position: "top-right",
            });
        },
        onError: () => {
            toast.error("Erro ao cadastrar pessoa!", {
                position: "top-right",
            });
        },
    });
};
</script>

<template>
    <v-app>
        <Menu :userProfile="userProfile" />
        <v-main class="bg-grey-lighten-4 mt-8">
            <v-container>
                <span>Atende Cidadão > Pessoas > Cadastro</span>
                <v-card class="mt-8 pa-4">
                    <v-card-title class="text-h4 my-8"
                        >Cadastrar Pessoa</v-card-title
                    >
                    <v-card-text>
                        <form @submit.prevent="submit">
                            <v-row>
                                <v-col>
                                    <v-text-field
                                        v-model="form.name"
                                        label="Nome:*"
                                        variant="outlined"
                                        @change="form.validate('name')"
                                    ></v-text-field>
                                    <span
                                        v-if="form.invalid('name')"
                                        class="text-base text-red-500"
                                    >
                                        {{ form.errors.name }}
                                    </span>
                                </v-col>
                                <v-col>
                                    <v-text-field
                                        v-model="form.birthday"
                                        label="Data de Nascimento:*"
                                        variant="outlined"
                                        type="date"
                                        @change="form.validate('birthday')"
                                    ></v-text-field>
                                    <span
                                        v-if="form.invalid('birthday')"
                                        class="text-base text-red-500"
                                    >
                                        {{ form.errors.birthday }}
                                    </span>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <v-text-field
                                        v-model="form.cpf"
                                        label="CPF:*"
                                        variant="outlined"
                                        @change="form.validate('cpf')"
                                        v-mask="'###.###.###-##'"
                                    ></v-text-field>
                                    <span
                                        v-if="form.invalid('cpf')"
                                        class="text-base text-red-500"
                                    >
                                        {{ form.errors.cpf }}
                                    </span>
                                </v-col>
                                <v-col>
                                    <v-select
                                        v-model="form.sex"
                                        label="Sexo:*"
                                        variant="outlined"
                                        :items="[
                                            'Masculino',
                                            'Feminino',
                                            'Outro',
                                        ]"
                                        @change="form.validate('sex')"
                                    ></v-select>
                                    <span
                                        v-if="form.invalid('sex')"
                                        class="text-base text-red-500"
                                    >
                                        {{ form.errors.sex }}
                                    </span>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <v-text-field
                                        v-model="form.city"
                                        label="Cidade"
                                        variant="outlined"
                                    ></v-text-field>
                                </v-col>
                                <v-col>
                                    <v-text-field
                                        v-model="form.neighborhood"
                                        label="Bairro"
                                        variant="outlined"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <v-text-field
                                        v-model="form.street"
                                        label="Rua"
                                        variant="outlined"
                                    ></v-text-field>
                                </v-col>
                                <v-col>
                                    <v-text-field
                                        v-model="form.number"
                                        label="Número"
                                        variant="outlined"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <v-text-field
                                        v-model="form.complement"
                                        label="Complemento"
                                        variant="outlined"
                                    ></v-text-field>
                                </v-col>
                                <v-col>
                                    <v-card-actions class="justify-end ga-6">
                                        <Link :href="route('people.index')">
                                            <v-btn
                                                rounded="xs"
                                                color="grey-darken-1"
                                                size="large"
                                                variant="tonal"
                                                >Voltar</v-btn
                                            >
                                        </Link>
                                        <v-btn
                                            rounded="xs"
                                            color="blue-darken-2"
                                            size="large"
                                            variant="tonal"
                                            @click="submit"
                                            >Salvar</v-btn
                                        >
                                    </v-card-actions>
                                </v-col>
                            </v-row>
                        </form>
                    </v-card-text>
                </v-card>
            </v-container>
        </v-main>
    </v-app>
</template>
