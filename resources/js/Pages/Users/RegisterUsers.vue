<script setup>
import { useForm } from "laravel-precognition-vue-inertia";
import { Link } from "@inertiajs/vue3";
import Menu from "../../Components/Menu.vue";
import { useToast } from "vue-toast-notification";
import { ref, defineProps } from "vue";

const props = defineProps({
    userAuth: Object,
});

const form = useForm("post", route("user.store"), {
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    terms: false,
    profile: "",
    cpf: "",
    active: "S",
});

const toast = useToast();

const selectedProfile = ref(
    props.userAuth.profile === "T" ? null : "Atendente"
);

const profile = (option) => {
    if (option === "Administrador da TI") {
        return "T";
    } else if (option === "Administrador do Sistema") {
        return "S";
    } else {
        return "A";
    }
};

const submit = () => {
    form.profile = profile(selectedProfile.value);
    form.submit({
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            selectedProfile.value = null;
            toast.success("Usuário criado com Sucesso!", {
                position: "top-right",
            });
        },
        onError: (error) => {
            toast.error("Erro criar Usuário!", {
                position: "top-right",
            });
        },
    });
};
</script>

<template>
    <v-app>
        <Menu />
        <v-main class="bg-grey-lighten-4 mt-8">
            <v-container>
                <span>Atende Cidadão > Usuários > Registro</span>
                <v-card class="mt-8 pa-4">
                    <v-card-title class="text-h4 my-8"
                        >Registrar Usuário</v-card-title
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
                                        v-model="form.email"
                                        label="E-mail:*"
                                        variant="outlined"
                                        type="email"
                                        @change="form.validate('email')"
                                    ></v-text-field>
                                    <span
                                        v-if="form.invalid('email')"
                                        class="text-base text-red-500"
                                    >
                                        {{ form.errors.email }}
                                    </span>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <v-text-field
                                        v-model="form.password"
                                        label="Senha:*"
                                        variant="outlined"
                                        type="password"
                                        autocomplete="new-password"
                                        @change="form.validate('password')"
                                    ></v-text-field>
                                    <span
                                        v-if="form.invalid('password')"
                                        class="text-base text-red-500"
                                    >
                                        {{ form.errors.password }}
                                    </span>
                                </v-col>
                                <v-col>
                                    <v-text-field
                                        v-model="form.password_confirmation"
                                        label="Confirme a senha:*"
                                        variant="outlined"
                                        type="password"
                                        autocomplete="new-password"
                                        @change="
                                            form.validate(
                                                'password_confirmation'
                                            )
                                        "
                                    ></v-text-field>
                                    <span
                                        v-if="
                                            form.invalid(
                                                'password_confirmation'
                                            )
                                        "
                                        class="text-base text-red-500"
                                    >
                                        {{ form.errors.password_confirmation }}
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
                                    <template v-if="userAuth.profile === 'T'">
                                        <v-select
                                            v-model="selectedProfile"
                                            label="Perfil:*"
                                            :items="[
                                                'Administrador da TI',
                                                'Administrador do Sistema',
                                                'Atendente',
                                            ]"
                                            variant="outlined"
                                            @change="form.validate('profile')"
                                        ></v-select>
                                    </template>
                                    <template v-else>
                                        <v-text-field
                                            v-model="selectedProfile"
                                            label="Perfil:*"
                                            variant="outlined"
                                            readonly
                                            @change="form.validate('profile')"
                                        ></v-text-field>
                                    </template>
                                    <span
                                        v-if="form.invalid('profile')"
                                        class="text-base text-red-500"
                                    >
                                        {{ form.errors.profile }}
                                    </span>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <v-card-actions class="justify-end ga-6">
                                        <Link :href="route('user.index')">
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
