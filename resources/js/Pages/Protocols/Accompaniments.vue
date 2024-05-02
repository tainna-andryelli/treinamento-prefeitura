<script setup>
import { useForm } from "laravel-precognition-vue-inertia";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import { defineProps, ref, computed } from "vue";
import { Link } from "@inertiajs/vue3";

const toast = useToast();

const props = defineProps({
    protocol: Object,
    accompaniments: Object,
});

const headers = [
    { title: "#", align: "left", value: "id" },
    { title: "Descrição", value: "description" },
    { title: "Situação", value: "status" },
    { title: "Data e Hora de criação:", value: "created_at" },
];

const accompanimentStatus = ref(null);
const formAccompaniment = useForm(
    "post",
    route("accompaniment.store", props.protocol.number),
    {
        description: "",
        status: "",
        protocol_number: props.protocol.number,
    }
);

const statusInterface = (option) => {
    if (option === "E") {
        return "Em atendimento";
    } else if (option === "S") {
        return "Solucionado";
    }

    return "Aberto";
};

const statusColor = (status) => {
    if (status === "E") {
        return "yellow";
    } else if (status === "S") {
        return "green";
    }

    return "red";
};

const statusBD = (option) => {
    if (option === "Em atendimento") {
        return "E";
    } else if (option === "Solucionado") {
        return "S";
    } else {
        return "A";
    }
};

const submitAccompaniment = () => {
    formAccompaniment.status = statusBD(accompanimentStatus.value);
    formAccompaniment.submit({
        preserveScroll: true,
        onSuccess: () => {
            formAccompaniment.reset();
            accompanimentStatus.value = null;
            toast.success("Acompanhamento criado com sucesso!", {
                position: "top-right",
            });
        },
        onError: () => {
            toast.error("Erro ao registrar acompanhamento!", {
                position: "top-right",
            });
        },
    });
};

const formatCreatedAt = (created_at) => {
    const date = new Date(created_at);
    const formattedDate = `${date.toLocaleDateString()} ${date.toLocaleTimeString()}`;

    return formattedDate;
};

//pagination
const itemsPerPage = ref(10);
const page = ref(1);
const pageCount = computed(() => {
    return Math.ceil(props.accompaniments.length / itemsPerPage.value);
});
</script>
<template>
    <v-card flat>
        <v-card-title class="text-h4 my-12"
            >Registro de Acompanhamento</v-card-title
        >
        <v-card-text>
            <form @submit.prevent="submit">
                <v-row>
                    <v-col>
                        <v-text-field
                            v-model="formAccompaniment.description"
                            label="Descrição:*"
                            variant="outlined"
                            @change="formAccompaniment.validate('description')"
                        ></v-text-field>
                        <span
                            v-if="formAccompaniment.invalid('description')"
                            class="text-base text-red-500"
                        >
                            {{ formAccompaniment.errors.description }}
                        </span>
                    </v-col>
                    <v-col>
                        <v-select
                            v-model="accompanimentStatus"
                            label="Situação:*"
                            :items="['Aberto', 'Em atendimento', 'Solucionado']"
                            variant="outlined"
                            @change="formAccompaniment.validate('status')"
                        ></v-select>
                        <span
                            v-if="formAccompaniment.invalid('status')"
                            class="text-base text-red-500"
                        >
                            {{ formAccompaniment.errors.status }}
                        </span>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col>
                        <v-card-actions class="justify-end ga-6">
                            <Link :href="route('protocols.index')">
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
                                color="blue"
                                size="large"
                                variant="tonal"
                                @click="submitAccompaniment"
                                >Salvar</v-btn
                            >
                        </v-card-actions>
                    </v-col>
                </v-row>
            </form>

            <div>
                <v-card-title class="text-h6 mt-12 pa-2"
                    >Acompanhamentos Realizados:</v-card-title
                >
                <v-data-table
                    v-model:page="page"
                    :headers="headers"
                    :items="accompaniments"
                    :items-per-page="itemsPerPage"
                >
                    <template v-slot:item="{ item }">
                        <tr>
                            <td>{{ item.id }}</td>
                            <td>{{ item.description }}</td>
                            <td>
                                <div class="d-flex flex-row align-center gap-2">
                                    <v-icon
                                        :color="statusColor(item.status)"
                                        icon="mdi-circle"
                                        size="medium"
                                    ></v-icon>
                                    {{ statusInterface(item.status) }}
                                </div>
                            </td>
                            <td>
                                {{ formatCreatedAt(item.created_at) }}
                            </td>
                        </tr>
                    </template>
                </v-data-table>
            </div>

            <v-pagination
                v-model="page"
                :length="pageCount"
                class="text-light-blue-darken-2 mt-8"
            ></v-pagination>
        </v-card-text>
    </v-card>
</template>
