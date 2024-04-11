<script>
export default {
    name: "Menu",
    data() {
        return {
            isDrawerOpen: false,
        };
    },
    methods: {
        redirect(route) {
            window.location.href = route;
        },
    },
    watch: {
        group() {
            this.isDrawerOpen = false;
        },
    },
};
</script>

<template>
    <v-navigation-drawer v-model="isDrawerOpen">
        <v-list>
            <v-list-subheader class="text-h5">Atende Cidadão</v-list-subheader>
            <v-list-item
                @click="redirect('/')"
                prepend-icon="mdi-home"
                title="Home"
            ></v-list-item>
            <v-list-item
                @click="redirect('/pessoas')"
                prepend-icon="mdi-folder-account-outline"
                title="Pessoas"
            ></v-list-item>
            <v-list-item
                @click="redirect('/protocolos')"
                prepend-icon="mdi-school"
                title="Protocolos"
            ></v-list-item>
            <v-list-item
                @click="redirect('/users')"
                prepend-icon="mdi-account-group-outline"
                title="Usuários"
            ></v-list-item>
            <v-list-item
                @click="redirect('/settings')"
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
