<script setup>
import { Link } from "@inertiajs/vue3";
import Menu from "../../Components/Menu.vue";
import { defineProps, computed } from "vue";

const props = defineProps({
    audit: Object,
    user: Object,
});

const formatCreatedAt = computed(() => {
    const date = new Date(props.audit.created_at);
    const formattedDate = `${date.toLocaleDateString()} ${date.toLocaleTimeString()}`;

    return formattedDate;
});

const showEvent = computed(() => {
    if (props.audit.event === "created") {
        return "Criação";
    } else if (props.audit.event === "updated") {
        return "Alteração";
    } else if (props.audit.event === "deleted") {
        return "Exclusão";
    } else if (props.audit.event === "restored") {
        return restaurado;
    } else if (props.audit.event === "forceDeleted") {
        return "Permanentemente excluído";
    }
    return "Não encontrado";
});
</script>
<template>
    <v-app>
        <Menu />
        <v-main class="bg-grey-lighten-4 mt-8">
            <v-container>
                <span>Atende Cidadão > Auditoria > Detalhes </span>
                <v-card class="mt-8 pa-4">
                    <v-card-title class="text-h4 my-8"
                        >Detalhes da Auditoria</v-card-title
                    >
                    <v-card-text>
                        <v-row>
                            <v-col>
                                <v-text-field
                                    v-model="audit.id"
                                    label="ID:"
                                    variant="outlined"
                                    readonly
                                ></v-text-field>
                            </v-col>
                            <v-col>
                                <v-text-field
                                    v-model="formatCreatedAt"
                                    label="Data e Hora de Criação:"
                                    variant="outlined"
                                    readonly
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col>
                                <v-text-field
                                    v-model="user.name"
                                    label="Usuário:"
                                    variant="outlined"
                                    readonly
                                ></v-text-field>
                            </v-col>
                            <v-col>
                                <v-text-field
                                    v-model="showEvent"
                                    label="Evento:"
                                    variant="outlined"
                                    readonly
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col>
                                <v-text-field
                                    v-model="audit.auditable_type"
                                    label="Tabela:"
                                    variant="outlined"
                                    readonly
                                ></v-text-field>
                            </v-col>
                            <v-col>
                                <v-text-field
                                    v-model="audit.auditable_id"
                                    label="ID Auditado:"
                                    variant="outlined"
                                    readonly
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col>
                                <v-text-field
                                    v-model="audit.url"
                                    label="URL:"
                                    variant="outlined"
                                    readonly
                                ></v-text-field>
                            </v-col>
                            <v-col>
                                <v-text-field
                                    v-model="audit.ip_address"
                                    label="IP:"
                                    variant="outlined"
                                    readonly
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col>
                                <v-card-actions class="justify-end ga-6">
                                    <Link :href="route('audits.index')">
                                        <v-btn
                                            rounded="xs"
                                            color="grey-darken-1"
                                            size="large"
                                            variant="tonal"
                                            >Voltar</v-btn
                                        >
                                    </Link>
                                </v-card-actions>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-container>
        </v-main>
    </v-app>
</template>
