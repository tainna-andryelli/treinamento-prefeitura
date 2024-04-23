<script setup>
import { useForm } from "laravel-precognition-vue-inertia";
import { Link } from "@inertiajs/vue3";
import Menu from "../../Components/Menu.vue";
import { useToast } from "vue-toast-notification";
import { ref, defineProps } from "vue";

const props = defineProps({
    user: Object,
    userAuth: Object,
});

const isEditable = ref(props.userAuth.profile === "T");

const form = useForm("put", route("user.update", props.user.id), {
    name: props.user.name,
    email: props.user.email,
    terms: false,
    profile: props.user.profile,
    cpf: props.user.cpf,
    active: props.user.active,
});

const toast = useToast();

const profileInterface = (option) => {
    if (option === "T") {
        return "Administrador da TI";
    } else if (option === "S") {
        return "Administrador do Sistema";
    } else {
        return "Atendente";
    }
};
const selectedProfile = ref(profileInterface(props.user.profile));

const profileBD = (option) => {
    if (option === "Administrador da TI") {
        return "T";
    } else if (option === "Administrador do Sistema") {
        return "S";
    } else {
        return "A";
    }
};

const selectedStatus = ref(props.user.active === "S" ? "Ativo" : "Desativado");

const submit = () => {
    form.profile = profileBD(selectedProfile.value);
    form.active = selectedStatus.value === "Ativo" ? "S" : "N";
    form.submit({
        preserveScroll: true,
        onSuccess: () => {
            toast.success("Usuário editado com Sucesso!", {
                position: "top-right",
            });
        },
        onError: () => {
            toast.error("Erro ao editar Usuário!", {
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
                <span>Atende Cidadão > Usuários > Visualização </span>
                <v-card class="mt-8 pa-4">
                    <v-card-title class="text-h4 my-8"
                        >Visualizar Usuário</v-card-title
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
                                        :readonly="!isEditable"
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
                                        label="E-mail:"
                                        variant="outlined"
                                        type="email"
                                        readonly
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
                                        v-model="form.cpf"
                                        label="CPF:"
                                        variant="outlined"
                                        v-mask="'###.###.###-##'"
                                        readonly
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
                                        v-model="selectedProfile"
                                        label="Perfil:*"
                                        :items="[
                                            'Administrador da TI',
                                            'Administrador do Sistema',
                                            'Atendente',
                                        ]"
                                        @change="form.validate('profile')"
                                        variant="outlined"
                                        :readonly="!isEditable"
                                    ></v-select>
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
                                    <v-select
                                        v-model="selectedStatus"
                                        label="Status:*"
                                        :items="['Ativo', 'Desativado']"
                                        variant="outlined"
                                        @change="form.validate('active')"
                                        :readonly="!isEditable"
                                    ></v-select>
                                    <span
                                        v-if="form.invalid('active')"
                                        class="text-base text-red-500"
                                    >
                                        {{ form.errors.active }}
                                    </span>
                                </v-col>
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
                                        <template
                                            v-if="userAuth.profile === 'T'"
                                        >
                                            <v-btn
                                                rounded="xs"
                                                color="blue-darken-2"
                                                size="large"
                                                variant="tonal"
                                                @click="submit"
                                                >Salvar</v-btn
                                            >
                                        </template>
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
