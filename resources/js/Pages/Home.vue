<template>
    <v-app>
        <v-navigation-drawer v-model="isDrawerOpen" permanent>
            <v-list>
                <v-list-subheader class="text-h5"
                    >Atende Cidadão</v-list-subheader
                >
                <v-list-item prepend-icon="mdi-home" title="Home"></v-list-item>
                <v-list-item
                    prepend-icon="mdi-folder-account-outline"
                    title="Pessoas"
                ></v-list-item>
                <v-list-item
                    prepend-icon="mdi-school"
                    title="Protocolos"
                ></v-list-item>
                <v-list-item
                    prepend-icon="mdi-account-group-outline"
                    title="Usuários"
                ></v-list-item>
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
            <!-- <v-app-bar-title></v-app-bar-title> -->

            <template #append>
                <v-avatar>
                    <v-icon icon="mdi-account-circle" color="white"></v-icon>
                </v-avatar>
            </template>
        </v-app-bar>

        <v-main>
            <v-container>
                <h1 class="text-h5">Home</h1>
                <v-row>
                    <!-- grid 12 colunas -->
                    <v-col cols="12" md="4" lg="3">
                        <v-card>
                            <v-img
                                class="align-end text-white"
                                src="https://images.pexels.com/photos/2765872/pexels-photo-2765872.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                                cover
                            >
                                <v-card-title>
                                    Tartarugas são fantásticas
                                </v-card-title>
                            </v-img>
                            <v-card-text> Tartarugas </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
export default {
    data() {
        return {
            isDrawerOpen: false,
        };
    },
    watch: {
        group() {
            this.isDrawerOpen = false;
        },
    },
};
</script>
