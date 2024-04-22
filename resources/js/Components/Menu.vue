<script setup>
import { ref, watch } from "vue";
import { Link } from "@inertiajs/vue3";

const isDrawerOpen = ref(false);
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
                        <v-list-item prepend-icon="mdi-account-outline">
                            <v-list-item-title>Meu Perfil</v-list-item-title>
                        </v-list-item>
                        <v-list-item prepend-icon="mdi-logout">
                            <v-list-item-title>Logout</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-menu>
        </template>
    </v-app-bar>
</template>
