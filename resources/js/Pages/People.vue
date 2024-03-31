<script>
import Menu from "../Components/Menu.vue";
export default {
    name: "People",
    components: {
        Menu,
    },
};
</script>

<template>
    <v-app>
        <Menu />
        <v-main class="bg-grey-lighten-4">
            <v-container>
                <span>Atende Cidadão > Pessoas</span>
                <v-table class="mt-8">
                    <thead>
                        <tr>
                            <th class="font-weight-bold text-subtitle-2">#</th>
                            <th class="font-weight-bold text-subtitle-2">
                                Nome
                            </th>
                            <th class="font-weight-bold text-subtitle-2">
                                CPF
                            </th>
                            <th class="font-weight-bold text-subtitle-2">
                                Data de Nascimento
                            </th>
                            <th class="font-weight-bold text-subtitle-2">
                                Sexo
                            </th>
                            <th class="font-weight-bold text-subtitle-2">
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Luana Gonçalvez</td>
                            <td>04927756789</td>
                            <td>12/12/1996</td>
                            <td>Feminino</td>
                            <td class="d-flex align-center ga-2">
                                <v-btn
                                    rounded="xs"
                                    color="light-blue-lighten-5"
                                    prepend-icon="mdi-pencil"
                                    size="small"
                                    class="text-light-blue-darken-2"
                                    >VISUALIZAR</v-btn
                                >
                                <v-btn
                                    rounded="xs"
                                    color="light-blue-lighten-5"
                                    prepend-icon="mdi-pencil"
                                    size="small"
                                    class="text-light-blue-darken-2"
                                    >EXCLUIR</v-btn
                                >
                            </td>
                        </tr>
                    </tbody>
                </v-table>
            </v-container>
        </v-main>
    </v-app>
</template>
