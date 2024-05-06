<script setup>
import { useForm } from "laravel-precognition-vue-inertia";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import { defineProps } from "vue";
import Menu from "../../Components/Menu.vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    person: Object,
    userProfile: String,
});

const form = useForm("put", route("people.update", props.person.id), {
    name: props.person.name,
    birthday: props.person.birthday,
    cpf: props.person.cpf,
    sex: props.person.sex,
    city: props.person.city,
    neighborhood: props.person.neighborhood,
    street: props.person.street,
    number: props.person.number,
    complement: props.person.complement,
});

const toast = useToast();

const submit = () =>
    form.submit({
        preserveScroll: true,
        onSuccess: () => {
            toast.success("Pessoa editada com sucesso!", {
                position: "top-right",
            });
        },
        onError: (error) => {
            toast.error("Erro ao editar pessoa!", {
                position: "top-right",
            });
        },
    });
</script>

<template>
    <v-app>
        <Menu :userProfile="userProfile" />
        <v-main class="bg-grey-lighten-4 mt-8">
            <v-container>
                <span>Atende Cidadão > Pessoas > Visualizar</span>
                <v-card class="mt-8 pa-4">
                    <v-card-title class="text-h4 my-8"
                        >Visualizar Pessoa</v-card-title
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
                                        v-mask="'###.###.###-##'"
                                        disabled
                                    ></v-text-field>
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
