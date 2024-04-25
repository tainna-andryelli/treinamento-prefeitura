<script setup>
import { useForm } from "laravel-precognition-vue-inertia";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import { defineProps, ref } from "vue";
import Menu from "../../Components/Menu.vue";
import { Link } from "@inertiajs/vue3";
import axios from "axios";

const props = defineProps({
    department: Object,
});

const itemProps = (item) => {
    return {
        title: item.name,
        subtitle: item.id,
    };
};

const toast = useToast();

const form = useForm("put", route("departments.update", props.department.id), {
    name: props.department.name,
});

const submit = () => {
    form.submit({
        preserveScroll: true,
        onSuccess: () => {
            toast.success("Departamento editado com sucesso!", {
                position: "top-right",
            });
        },
        onError: () => {
            toast.error("Erro ao editar Departamento!", {
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
                <span>Atende Cidadão > Departamentos > Visualizar</span>
                <v-card class="mt-8 pa-4">
                    <v-card-title class="text-h4 my-12"
                        >Visualizar Departamento</v-card-title
                    >
                    <v-card-text>
                        <form @submit.prevent="submit">
                            <v-row>
                                <v-text-field
                                    v-model="form.name"
                                    label="Nome do Departamento:*"
                                    variant="outlined"
                                    @change="form.validate('name')"
                                ></v-text-field>
                                <span
                                    v-if="form.invalid('name')"
                                    class="text-base text-red-500"
                                >
                                    {{ form.errors.name }}
                                </span>
                            </v-row>

                            <v-row class="justify-end">
                                <v-card-actions class="justify-end ga-6">
                                    <Link :href="route('departments.index')">
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
                            </v-row>
                        </form>
                    </v-card-text>
                </v-card>
            </v-container>
        </v-main>
    </v-app>
</template>
