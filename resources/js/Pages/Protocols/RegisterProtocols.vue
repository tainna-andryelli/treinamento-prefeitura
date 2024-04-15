<script setup>
import { useForm } from "laravel-precognition-vue-inertia";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import Menu from "../../Components/Menu.vue";
import { defineProps, ref } from "vue";

const props = defineProps({
    people: Object,
});

const itemProps = (item) => {
    return {
        title: item.name,
        subtitle: item.id,
    };
};

const selectedContributorId = ref(null);

const form = useForm("post", route("protocols.store"), {
    description: "",
    created_date: "",
    deadline_days: "",
    contributor_id: "",
});

const toast = useToast();

const submit = () => {
    form.contributor_id = selectedContributorId.value;
    form.submit({
        preserveScroll: true,
        onSuccess: () => {
            selectedContributorId.value = null;
            form.reset();
            toast.success("Protocolo registrado com sucesso!", {
                position: "top-right",
            });
        },
        onError: () => {
            toast.error("Erro ao registrar protocolo!", {
                position: "top-right",
            });
        },
    });
};
</script>

<template>
    <v-app>
        <Menu />
        <v-main class="bg-grey-lighten-4 mt-8">
            <v-container>
                <span>Atende Cidadão > Procotolos > Cadastro</span>
                <v-card class="mt-8 pa-4">
                    <v-card-title class="text-h5 my-8"
                        >Registrar Protocolo</v-card-title
                    >
                    <v-card-text>
                        <form @submit.prevent="submit">
                            <v-row>
                                <v-col>
                                    <v-text-field
                                        v-model="form.description"
                                        label="Descrição:*"
                                        variant="outlined"
                                        @change="form.validate('description')"
                                    ></v-text-field>
                                    <span
                                        v-if="form.invalid('description')"
                                        class="text-base text-red-500"
                                    >
                                        {{ form.errors.description }}
                                    </span>
                                </v-col>
                                <v-col>
                                    <v-text-field
                                        v-model="form.created_date"
                                        label="Data de criação:*"
                                        variant="outlined"
                                        type="date"
                                        @change="form.validate('created_date')"
                                    ></v-text-field>
                                    <span
                                        v-if="form.invalid('created_date')"
                                        class="text-base text-red-500"
                                    >
                                        {{ form.errors.created_date }}
                                    </span>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <v-text-field
                                        v-model="form.deadline_days"
                                        label="Prazo:*"
                                        variant="outlined"
                                        @change="form.validate('deadline_days')"
                                    ></v-text-field>
                                    <span
                                        v-if="form.invalid('deadline_days')"
                                        class="text-base text-red-500"
                                    >
                                        {{ form.errors.deadline_days }}
                                    </span>
                                </v-col>
                                <v-col>
                                    <v-select
                                        v-model="selectedContributorId"
                                        label="Contribuinte:*"
                                        variant="outlined"
                                        :item-props="itemProps"
                                        :items="props.people"
                                        item-value="id"
                                        item-text="name"
                                        @change="
                                            form.validate('contributor_id')
                                        "
                                    ></v-select>
                                    <span
                                        v-if="form.invalid('contributor_id')"
                                        class="text-base text-red-500"
                                    >
                                        {{ form.errors.contributor_id }}
                                    </span>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <v-card-actions class="justify-end ga-6">
                                        <v-btn
                                            :href="route('protocols.index')"
                                            rounded="xs"
                                            color="grey"
                                            size="large"
                                            variant="tonal"
                                            >Voltar</v-btn
                                        >
                                        <v-btn
                                            rounded="xs"
                                            color="blue"
                                            size="large"
                                            variant="tonal"
                                            @click="submit"
                                            >Salvar</v-btn
                                        >
                                    </v-card-actions>
                                </v-col>
                            </v-row>
                        </form>
                    </v-card-text>
                </v-card>
            </v-container>
        </v-main>
    </v-app>
</template>
