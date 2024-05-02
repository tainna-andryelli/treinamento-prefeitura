<script setup>
import Menu from "../Components/Menu.vue";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <v-app>
        <Menu />
        <v-main>
            <v-container class="d-flex flex-column ga-6">
                <h1 class="text-h4 mt-6">Home</h1>
                <p>Bem-vindo ao canal <strong>Atende Cidadão.</strong></p>
                <p>
                    Você visualiza as <strong>Pessoas</strong> cadastradas no
                    sistema clicando
                    <Link :href="route('people.index')" class="text-blue"
                        >aqui</Link
                    >.
                </p>
                <p>
                    Você visualiza os <strong>Protocolos</strong> clicando
                    <Link :href="route('protocols.index')" class="text-blue"
                        >aqui</Link
                    >.
                </p>
                <p>
                    Veja os <strong>Usuários</strong> clicando
                    <Link :href="route('user.index')" class="text-blue"
                        >aqui</Link
                    >.
                </p>
                <p>
                    Confira os <strong>Departamentos</strong> clicando
                    <Link :href="route('departments.index')" class="text-blue"
                        >aqui</Link
                    >.
                </p>
                <p>
                    Confira a <strong>Auditoria</strong> para acompanhar cada
                    alteração feita no sistema clicando
                    <Link :href="route('audits.index')" class="text-blue"
                        >aqui</Link
                    >.
                </p>
            </v-container>
        </v-main>
    </v-app>
</template>
