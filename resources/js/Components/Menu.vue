<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import axios from "axios";

const isDrawerOpen = ref(false);
const isSubmitting = ref(false);

const logout = () => {
    isSubmitting.value = true;
    axios
        .post(route("logout"))
        .then(() => {
            window.location.href = route("welcome");
        })
        .catch((error) => {
            console.error("Erro ao efetuar logout:", error);
            isSubmitting.value = false;
        });
};
</script>

<template>
    <v-navigation-drawer v-model="isDrawerOpen">
        <v-list>
            <v-list-subheader class="text-h5">Atende Cidadão</v-list-subheader>
            <Link :href="route('home')">
                <v-list-item prepend-icon="mdi-home" title="Home"></v-list-item>
            </Link>
            <Link :href="route('people.index')">
                <v-list-item
                    prepend-icon="mdi-folder-account-outline"
                    title="Pessoas"
                ></v-list-item>
            </Link>
            <Link :href="route('protocols.index')">
                <v-list-item
                    prepend-icon="mdi-school"
                    title="Protocolos"
                ></v-list-item>
            </Link>
            <Link :href="route('user.index')">
                <v-list-item
                    prepend-icon="mdi-account-group-outline"
                    title="Usuários"
                ></v-list-item>
            </Link>
            <Link :href="route('departments.index')">
                <v-list-item
                    prepend-icon="mdi-badge-account-horizontal-outline"
                    title="Departamentos"
                ></v-list-item>
            </Link>
            <v-list-item
                prepend-icon="mdi-cog-outline"
                title="Configurações"
            ></v-list-item>
        </v-list>
    </v-navigation-drawer>
    <v-app-bar flat color="blue">
        <v-app-bar-nav-icon
            @click="isDrawerOpen = !isDrawerOpen"
        ></v-app-bar-nav-icon>
        <v-app-bar-title v-if="!isDrawerOpen">Atende Cidadão</v-app-bar-title>

        <template #append>
            <v-menu transition="slide-x-transition">
                <template v-slot:activator="{ props }">
                    <v-avatar class="cursor-pointer" v-bind="props">
                        <v-icon
                            icon="mdi-account-circle"
                            color="white"
                        ></v-icon>
                    </v-avatar>
                </template>

                <v-card min-width="150px">
                    <v-list :lines="false" nav density="compact">
                        <v-list-item>
                            <v-btn
                                rounded="xs"
                                color="light-blue-lighten-5"
                                prepend-icon="mdi-account-outline"
                                size="small"
                                class="text-light-blue-darken-2"
                                variant="tonal"
                            >
                                Meu Perfil
                            </v-btn>
                        </v-list-item>
                        <v-list-item>
                            <v-btn
                                @click="logout"
                                rounded="xs"
                                color="light-blue-lighten-5"
                                prepend-icon="mdi-logout"
                                size="small"
                                class="text-light-blue-darken-2"
                                variant="tonal"
                            >
                                Sair
                            </v-btn>
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-menu>
        </template>
    </v-app-bar>
</template>
