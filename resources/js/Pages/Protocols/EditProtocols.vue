<script setup>
import { useForm } from "laravel-precognition-vue-inertia";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import { defineProps, ref } from "vue";
import Menu from "../../Components/Menu.vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    protocol: Object,
    people: Object,
    files: Object,
});

const itemProps = (item) => {
    return {
        title: item.name,
        subtitle: item.id,
    };
};

const isDialogOpen = ref(false);
const selectedFileToRemove = ref(null);
const deleteForm = ref();
const toast = useToast();

const form = useForm("put", route("protocols.update", props.protocol.number), {
    description: props.protocol.description,
    created_date: props.protocol.created_date,
    deadline_days: props.protocol.deadline_days,
    contributor_id: props.protocol.contributor_id,
    files: Array.from(props.files),
});

const onFileChange = (event) => {
    const newFiles = Array.from(event.target.files);
    form.files = form.files.concat(newFiles);
    form.validate("files");
};

const removeFile = (fileToRemove) => {
    selectedFileToRemove.value = fileToRemove;
    isDialogOpen.value = true;
    deleteForm.value = useForm(
        "delete",
        `/protocolos/arquivo-${fileToRemove.id}`,
        {
            id: fileToRemove.id,
        }
    );
};

const deleteFile = () => {
    deleteForm.value.submit({
        preserveScroll: true,
        onSuccess: () => {
            toast.success("Arquivo excluído com sucesso!", {
                position: "top-right",
            });

            //atualiza a lista que renderiza Arquivos Selecionados ao deletar um arquivo com sucesso:
            const index = form.files.findIndex(
                (file) => selectedFileToRemove.value.id === file.id
            );
            if (index !== -1) {
                form.files.splice(index, 1);
            }

            isDialogOpen.value = false;
        },
        onError: () => {
            toast.error("Erro ao excluir arquivo!", {
                position: "top-right",
            });
        },
    });
};

const downloadFileForm = ref();
const downloadFile = (file) => {
    console.log("realiza download de:", file);
    downloadFileForm.value = useForm(
        "get",
        `/protocolos/download/arquivo-${file.id}`,
        {
            id: file.id,
        }
    );

    downloadFileForm.value.submit({
        preserveScroll: true,
        onSuccess: () => {
            toast.success("Download realizado com sucesso!", {
                position: "top-right",
            });
        },
        onError: () => {
            toast.error("Erro ao realizar download!", {
                position: "top-right",
            });
        },
    });
};

const submit = () => {
    form.submit({
        preserveScroll: true,
        onSuccess: () => {
            toast.success("Protocolo editado com sucesso!", {
                position: "top-right",
            });
        },
        onError: (error) => {
            toast.error("Erro ao editar protocolo!", {
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
                <span>Atende Cidadão > Protocolos > Visualizar</span>
                <v-card class="mt-8 pa-4">
                    <v-card-title class="text-h4 my-8"
                        >Visualizar Protocolo</v-card-title
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
                                        label="Data de Criação:*"
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
                                        v-model="form.contributor_id"
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
                                    <label
                                        for="fileInput"
                                        class="inline-block px-4 py-2 bg-blue-lighten-1 text-base text-white rounded-md cursor-pointer"
                                    >
                                        Anexar arquivos
                                        <input
                                            id="fileInput"
                                            type="file"
                                            name="files"
                                            multiple
                                            @change="onFileChange"
                                            class="hidden"
                                        />
                                    </label>
                                    <span
                                        v-if="
                                            form.errors.files ||
                                            form.errors['files.0'] ||
                                            form.errors['files.1'] ||
                                            form.errors['files.2'] ||
                                            form.errors['files.3'] ||
                                            form.errors['files.4']
                                        "
                                        v-text="
                                            form.errors.files ||
                                            form.errors['files.0'] ||
                                            form.errors['files.1'] ||
                                            form.errors['files.2'] ||
                                            form.errors['files.3'] ||
                                            form.errors['files.4']
                                        "
                                        class="block text-base text-red-500 mt-4"
                                    >
                                    </span>
                                    <div
                                        v-if="
                                            form.files && form.files.length > 0
                                        "
                                        class="mt-4"
                                    >
                                        <p class="font-bold text-base mb-2">
                                            Arquivos selecionados:
                                        </p>
                                        <ul class="d-flex flex-column ga-1">
                                            <li
                                                v-for="file in form.files"
                                                :key="file.id"
                                            >
                                                <v-btn
                                                    @click="removeFile(file)"
                                                    color="white"
                                                    icon="mdi-close"
                                                    class="bg-red-lighten-1"
                                                    size="x-small"
                                                    elevation="0"
                                                >
                                                </v-btn>
                                                <v-btn
                                                    class="text-base ml-2"
                                                    color="blue-lighten-1"
                                                    @click="downloadFile(file)"
                                                    size="small"
                                                    elevation="0"
                                                    >{{
                                                        file.filename ||
                                                        file.name
                                                    }}</v-btn
                                                >
                                            </li>
                                        </ul>
                                    </div>
                                </v-col>
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
                                            color="blue-darken-2"
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

        <v-dialog v-model="isDialogOpen" width="500px">
            <v-card class="d-flex ga-4 pa-8 bg-red-lighten-1">
                <v-card-title class="text-h4">Deletar Arquivo</v-card-title>
                <v-card-text class="pa-4"
                    >Tem certeza que deseja deletar o arquivo
                    {{
                        selectedFileToRemove.filename ||
                        selectedFileToRemove.name
                    }}?</v-card-text
                >
                <v-card-actions class="ga-6">
                    <v-btn
                        @click="isDialogOpen = false"
                        rounded="xs"
                        color="white"
                        size="large"
                        variant="tonal"
                        >Cancelar</v-btn
                    >
                    <v-btn
                        rounded="xs"
                        color="black"
                        size="large"
                        variant="tonal"
                        @click="deleteFile"
                        >Confirmar</v-btn
                    >
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-app>
</template>
