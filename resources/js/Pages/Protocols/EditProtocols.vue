<script setup>
import { useForm } from "laravel-precognition-vue-inertia";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import { defineProps, ref } from "vue";
import Menu from "../../Components/Menu.vue";
import { Link } from "@inertiajs/vue3";
import axios from "axios";

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
    //files: Array.from(props.files),
    //files: [],
});

const formFiles = useForm(
    "post",
    route("protocols.uploadFile", props.protocol.number),
    {
        files: [],
    }
);

const onFileChange = (event) => {
    const newFile = Array.from(event.target.files);
    formFiles.files = formFiles.files.concat(newFile);
    formFiles.validate("files");
};

const removeNewFile = (index) => {
    formFiles.files.splice(index, 1);
};

//Remove arquivos do Banco de dados:
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
            isDialogOpen.value = false;
            toast.success("Arquivo excluído com sucesso!", {
                position: "top-right",
            });
        },
        onError: () => {
            toast.error("Erro ao excluir arquivo!", {
                position: "top-right",
            });
        },
    });
};

const downloadFile = (file) => {
    axios
        .get(route("protocols.downloadFile", { id: file.id }), {
            responseType: "blob",
        })
        .then((response) => {
            const url = window.URL.createObjectURL(response.data);
            const downloadLink = document.getElementById("downloadLink");
            downloadLink.href = url;

            downloadLink.setAttribute("download", file.filename || file.name); // nome do arquivo para download
            downloadLink.click();
        })
        .catch((error) => {
            toast.error("Erro ao realizar download!", {
                position: "top-right",
            });
        });
};

const submit = () => {
    form.submit({
        preserveScroll: true,
        onSuccess: () => {
            formFiles.submit({
                preserveScroll: true,
                onSuccess: () => {
                    toast.success("Protocolo editado com sucesso!", {
                        position: "top-right",
                    });
                    formFiles.files = [];
                },
                onError: () => {
                    toast.error("Erro ao anexar arquivo!", {
                        position: "top-right",
                    });
                },
            });
        },
        onError: () => {
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
                                        class="inline-block px-4 py-2 bg-blue text-base text-white rounded-md cursor-pointer"
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
                                    <span class="ml-2"
                                        >Até 5 arquivos nos formatos: JPG, JPEG,
                                        PNG e PDF.</span
                                    >
                                    <span
                                        v-if="
                                            formFiles.errors.files ||
                                            formFiles.errors['files.0'] ||
                                            formFiles.errors['files.1'] ||
                                            formFiles.errors['files.2'] ||
                                            formFiles.errors['files.3'] ||
                                            formFiles.errors['files.4']
                                        "
                                        v-text="
                                            formFiles.errors.files ||
                                            formFiles.errors['files.0'] ||
                                            formFiles.errors['files.1'] ||
                                            formFiles.errors['files.2'] ||
                                            formFiles.errors['files.3'] ||
                                            formFiles.errors['files.4']
                                        "
                                        class="block text-base text-red-500 mt-4"
                                    >
                                    </span>
                                    <div
                                        v-if="
                                            files.length > 0 ||
                                            formFiles.files.length > 0
                                        "
                                        class="mt-4"
                                    >
                                        <p class="font-bold text-base mb-2">
                                            Arquivos selecionados:
                                        </p>
                                        <ul class="d-flex flex-column ga-1">
                                            <li
                                                v-for="file in props.files"
                                                :key="file.id"
                                            >
                                                <v-btn
                                                    @click="removeFile(file)"
                                                    color="white"
                                                    class="text-red-lighten-1"
                                                    icon="mdi-delete"
                                                    size="xs-small"
                                                    elevation="0"
                                                >
                                                </v-btn>
                                                <a id="downloadLink">
                                                    <v-btn
                                                        class="text-base ml-2 text-white"
                                                        color="blue-lighten-1"
                                                        @click="
                                                            downloadFile(file)
                                                        "
                                                        size="small"
                                                        elevation="0"
                                                        >{{
                                                            file.filename ||
                                                            file.name
                                                        }}</v-btn
                                                    >
                                                </a>
                                            </li>
                                            <template
                                                v-if="
                                                    formFiles.files &&
                                                    formFiles.files.length > 0
                                                "
                                            >
                                                <li
                                                    v-for="(
                                                        file, index
                                                    ) in formFiles.files"
                                                    :key="index"
                                                >
                                                    <v-btn
                                                        @click="
                                                            removeNewFile(index)
                                                        "
                                                        color="white"
                                                        class="text-red-lighten-1"
                                                        icon="mdi-delete"
                                                        size="xs-small"
                                                        elevation="0"
                                                    >
                                                    </v-btn>
                                                    <a id="downloadLink">
                                                        <v-btn
                                                            class="text-base ml-2"
                                                            color="green-lighten-1"
                                                            @click="
                                                                downloadFile(
                                                                    file
                                                                )
                                                            "
                                                            size="small"
                                                            elevation="0"
                                                            >{{
                                                                file.filename ||
                                                                file.name
                                                            }}</v-btn
                                                        >
                                                    </a>
                                                </li>
                                            </template>
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
