<script setup>
import { Link } from "@inertiajs/vue3";
import Menu from "../../Components/Menu.vue";
import { defineProps, computed, ref } from "vue";

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

const newValues = computed(() => {
    const newValuesAudit = props.audit.new_values;

    if (newValuesAudit === null || newValuesAudit.length == 0)
        return "Nenhum valor novo atribuído a essa ação.";

    const jsonString = JSON.stringify(newValuesAudit, null, 2);
    const trimmedString = jsonString.slice(1, -1);
    const formattedString = trimmedString.replace(/,/g, "\n");
    const lines = formattedString
        .split("\n")
        .filter((line) => line.trim() !== "");

    return lines.join("\n");
});

const oldValues = computed(() => {
    const oldValuesAudit = props.audit.old_values;

    if (oldValuesAudit == null || oldValuesAudit.length == 0)
        return "Nenhum valor antigo atribuído a essa ação.";

    const jsonString = JSON.stringify(oldValuesAudit, null, 2);
    const trimmedString = jsonString.slice(1, -1);
    const formattedString = trimmedString.replace(/,/g, "\n");
    const lines = formattedString
        .split("\n")
        .filter((line) => line.trim() !== "");

    return lines.join("\n");
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
                                <v-textarea
                                    v-model="newValues"
                                    label="Novos Valores:"
                                    variant="outlined"
                                    readonly
                                ></v-textarea>
                            </v-col>
                            <v-col>
                                <v-textarea
                                    v-model="oldValues"
                                    label="Valores Antigos:"
                                    variant="outlined"
                                    readonly
                                ></v-textarea>
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
