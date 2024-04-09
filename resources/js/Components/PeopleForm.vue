<script>
import { useForm } from "laravel-precognition-vue";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import { ref } from "vue";

export default {
    name: "PeopleForm",
    emits: ["closeDialog"],
    props: {
        isEditing: Boolean,
        item: Object,
    },
    setup(props) {
        const toast = useToast();

        const formData = ref({
            name: props.isEditing ? props.item.name : "",
            birthday: props.isEditing ? props.item.birthday : "",
            cpf: props.isEditing ? props.item.cpf : "",
            sex: props.isEditing ? props.item.sex : "",
            city: props.isEditing ? props.item.city : "",
            neighborhood: props.isEditing ? props.item.neighborhood : "",
            street: props.isEditing ? props.item.street : "",
            number: props.isEditing ? props.item.number : "",
            complement: props.isEditing ? props.item.complement : "",
        });

        const formRegister = useForm("post", route("people.store"), formData);
        const formEdit = useForm(
            "put",
            route("people.update", { id: props.item.id }),
            formData
        );

        const submitForm = (id) => {
            if (id && props.isEditing) {
                formEdit.submit({
                    preserveScroll: true,
                    onSuccess: () => {
                        formEdit.reset();
                        toast.success("Pessoa editada com sucesso!", {
                            position: "top-right",
                        });
                    },
                    onError: () => {
                        toast.open({
                            message: "Erro ao editar pessoa!",
                            type: "error",
                            position: "top-right",
                        });
                    },
                });
            } else {
                formRegister.submit({
                    preserveScroll: true,
                    onSuccess: () => {
                        formRegister.reset();
                        toast.success("Pessoa criada com sucesso!", {
                            position: "top-right",
                        });
                    },
                    onError: () => {
                        toast.open({
                            message: "Erro ao criar pessoa!",
                            type: "error",
                            position: "top-right",
                        });
                    },
                });
            }

            this.$emit("closeDialog");
        };

        return {
            submitForm,
            formData,
        };
    },
};
</script>

<template>
    <v-card>
        <v-card-title class="text-h5 ma-4">{{ title }}</v-card-title>
        <v-card-text>
            <v-form
                @submit.prevent="
                    this.isEditing ? submitForm(item.id) : submitForm({})
                "
            >
                <v-row>
                    <v-col>
                        <v-text-field
                            v-model="formData.name"
                            label="Nome:*"
                            variant="outlined"
                        ></v-text-field>
                    </v-col>
                    <v-col>
                        <v-text-field
                            v-model="formData.birthday"
                            label="Data de Nascimento:*"
                            variant="outlined"
                            type="date"
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col>
                        <v-text-field
                            v-model="formData.cpf"
                            label="CPF:*"
                            variant="outlined"
                            :disabled="isEditing"
                        ></v-text-field>
                    </v-col>
                    <v-col>
                        <v-select
                            v-model="formData.sex"
                            label="Sexo:*"
                            variant="outlined"
                            :items="['Masculino', 'Feminino', 'Outro']"
                        ></v-select>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col>
                        <v-text-field
                            v-model="formData.city"
                            label="Cidade"
                            variant="outlined"
                        ></v-text-field>
                    </v-col>
                    <v-col>
                        <v-text-field
                            v-model="formData.neighborhood"
                            label="Bairro"
                            variant="outlined"
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col>
                        <v-text-field
                            v-model="formData.street"
                            label="Rua"
                            variant="outlined"
                        ></v-text-field>
                    </v-col>
                    <v-col>
                        <v-text-field
                            v-model="formData.number"
                            label="Número"
                            variant="outlined"
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col>
                        <v-text-field
                            v-model="formData.complement"
                            label="Complemento"
                            variant="outlined"
                        ></v-text-field>
                    </v-col>
                    <v-col>
                        <v-card-actions class="justify-end ga-6">
                            <v-btn
                                rounded="xs"
                                color="grey"
                                size="large"
                                variant="tonal"
                                @click="$emit('closeDialog')"
                                >Cancelar</v-btn
                            >
                            <v-btn
                                rounded="xs"
                                color="blue"
                                size="large"
                                variant="tonal"
                                type="submit"
                                >Salvar</v-btn
                            >
                        </v-card-actions>
                    </v-col>
                </v-row>
            </v-form>
        </v-card-text>
    </v-card>
</template>
