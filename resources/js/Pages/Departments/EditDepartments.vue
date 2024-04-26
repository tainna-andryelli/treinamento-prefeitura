<script setup>
import { useForm } from "laravel-precognition-vue-inertia";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import { defineProps, ref } from "vue";
import Menu from "../../Components/Menu.vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    department: Object,
    users: Object,
    access: Object,
    usersInAccess: Object,
});

const itemProps = (item) => {
    return {
        title: item.name,
        subtitle: "ID: " + item.id,
    };
};

const toast = useToast();
const selectedUserId = ref(null);

const tab = ref(0);
const changeTab = (newTab) => {
    tab.value = newTab;
};

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

const formUserAccess = useForm(
    "post",
    route("access.store", props.department.id),
    {
        user_id: "",
        department_id: props.department.id,
    }
);

const releaseAccess = () => {
    formUserAccess.user_id = selectedUserId.value;
    formUserAccess.validate("department_id");
    formUserAccess.submit({
        preserveScroll: true,
        onSuccess: () => {
            toast.success("Permissão de acesso realizada com sucesso!", {
                position: "top-right",
            });
        },
        onError: () => {
            toast.error("Erro ao liberar acesso!", {
                position: "top-right",
            });
        },
    });
};

const destroyAccessForm = ref();
const isDialogOpen = ref(false);
const user = ref();
const openDelete = (item) => {
    isDialogOpen.value = true;
    user.value = item;
    destroyAccessForm.value = useForm(
        "delete",
        `/departamentos/departamento-${props.department.id}/usuario-${item.id}`,
        {
            user_id: item.id,
            department_id: props.department.id,
        }
    );
};
const destroyAccess = () => {
    destroyAccessForm.value.submit({
        preserveScroll: true,
        onSuccess: () => {
            toast.success("Acesso removido com sucesso!", {
                position: "top-right",
            });
            isDialogOpen.value = false;
        },
        onError: () => {
            toast.error("Erro ao remover acesso!", {
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
                    <v-tabs v-model="tab" align-tabs="start">
                        <v-tab @click="changeTab(0)" class="text-blue-darken-2"
                            >Departamento</v-tab
                        >
                        <v-tab @click="changeTab(1)" class="text-blue-darken-2"
                            >Usuários</v-tab
                        >
                    </v-tabs>

                    <v-card flat v-if="tab === 0">
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
                                        <Link
                                            :href="route('departments.index')"
                                        >
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

                    <v-card flat v-if="tab === 1">
                        <v-card-title class="text-h4 mt-12 mb-4"
                            >Usuários:
                        </v-card-title>
                        <v-card-text>
                            <v-autocomplete
                                v-model="selectedUserId"
                                label="Selecione um usuário:"
                                variant="outlined"
                                :item-props="itemProps"
                                :items="props.users"
                                item-value="id"
                                item-text="name"
                                @change="formUserAccess.validate('user_id')"
                            ></v-autocomplete>
                            <span
                                v-if="formUserAccess.invalid('user_id')"
                                class="text-base text-red-500"
                            >
                                {{ formUserAccess.errors.user_id }}
                            </span>
                            <span
                                v-if="formUserAccess.invalid('department_id')"
                                class="text-base text-red-500"
                            >
                                {{ formUserAccess.errors.department_id }}
                            </span>
                            <v-card-actions class="justify-end ga-6">
                                <v-btn
                                    rounded="xs"
                                    color="blue-darken-2"
                                    size="large"
                                    variant="tonal"
                                    @click="releaseAccess"
                                    >Liberar Acesso</v-btn
                                >
                            </v-card-actions>
                            <v-divider
                                class="my-12"
                                thickness="3px"
                                color="black"
                            />
                            <div v-if="access" class="mt-4">
                                <p class="font-bold text-h5 mb-4">
                                    Usuários com Acesso:
                                </p>
                                <ul class="d-flex flex-column ga-1">
                                    <li
                                        v-for="(item, index) in usersInAccess"
                                        :key="index"
                                        class="d-flex align-items-center"
                                    >
                                        <v-btn
                                            @click="openDelete(item)"
                                            color="red-lighten-1"
                                            variant="tonal"
                                            icon="mdi-delete"
                                            size="xs-small"
                                            elevation="0"
                                        >
                                        </v-btn>
                                        <span class="text-base ml-2"
                                            ><strong>ID:</strong>
                                            {{ item.id }}</span
                                        >
                                        <span class="text-base ml-2"
                                            ><strong>Nome:</strong>
                                            {{ item.name }}</span
                                        >
                                    </li>
                                </ul>
                            </div>
                        </v-card-text>
                    </v-card>
                </v-card>
            </v-container>
        </v-main>

        <v-dialog v-model="isDialogOpen" width="500px">
            <v-card class="d-flex ga-4 pa-8 bg-red-lighten-1">
                <v-card-title class="text-h4">Remover Acesso</v-card-title>
                <v-card-text class="pa-4"
                    >Tem certeza que deseja remover o acesso ao departamento da
                    {{ user.name }}?</v-card-text
                >
                <v-card-actions class="ga-6">
                    <v-btn
                        @click="isDialogOpen = false"
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
                        @click="destroyAccess"
                        >Confirmar</v-btn
                    >
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-app>
</template>
