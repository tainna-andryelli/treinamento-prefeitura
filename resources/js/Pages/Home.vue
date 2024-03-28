<script>
import Menu from "../Components/Menu.vue";

export default {
    components: {
        Menu,
    },
};
</script>

<template>
    <v-app>
        <Menu />
        <v-main>
            <v-container class="d-flex flex-column ga-6">
                <h1 class="text-h5 mt-6">Home</h1>
                <p>Bem-vindo ao canal <strong>Atende Cidadão.</strong></p>
                <p>
                    Você visualiza as <strong>Pessoas</strong> cadastradas no
                    sistema clicando
                    <a class="text-blue" href="/people">aqui</a>.
                </p>
                <p>
                    Você visualiza os <strong>Protocolos</strong> clicando
                    <a class="text-blue" href="/protocolos">aqui</a>.
                </p>
                <p>
                    Veja os <strong>Usuários</strong> clicando
                    <a class="text-blue" href="/usuarios">aqui</a>.
                </p>
            </v-container>
        </v-main>
    </v-app>
</template>
