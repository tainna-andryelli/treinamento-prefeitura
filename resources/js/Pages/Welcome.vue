<script setup>
import { Head, Link } from "@inertiajs/vue3";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Boas Vindas!" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <img
            id="background"
            class="absolute top-0 left-0 w-screen h-screen object-cover opacity-30"
            src="https://cdn.pixabay.com/photo/2019/12/17/17/09/woman-4702060_1280.jpg"
        />
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white"
        >
            <div class="relative w-full max-w-2xl lg:max-w-7xl">
                <div
                    class="flex lg:justify-center lg:col-start-2 flex-col align-center justify-content-center ga-8 bg-gray-50 rounded px-12 py-16 w-50"
                >
                    <img
                        class="h-24 w-auto"
                        src="https://upload.wikimedia.org/wikipedia/commons/f/fd/Bras%C3%A3o_de_S%C3%A3o_Leopoldo_-_RS.svg"
                    />
                    <h1 class="text-h4 text-blue">
                        Bem-vindo à Central de Atendimento
                        <strong>Atende Cidadão!</strong>
                    </h1>
                    <p class="text-base text-black">
                        Aqui <strong>simplificamos</strong> e
                        <strong>agilizamos</strong> o processo de registro e
                        acompanhamentos de protocolos, proporcionando uma
                        experiência mais <strong>eficiente</strong> para os
                        cidadãos e uma gestão mais
                        <strong>organizada</strong> para a prefeitura.
                    </p>
                    <p class="text-base text-black">
                        Para acessar o sistema, é necessário ter um email e
                        senha cadastrados pelo administrador.
                    </p>
                    <nav v-if="canLogin">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('home')"
                            class="text-base text-white bg-blue-500 py-2 px-4 rounded-md w-auto"
                        >
                            Página Inicial
                        </Link>

                        <template v-else>
                            <p class="text-base text-black">
                                Solicite ao administrador suas
                                <strong>credenciais</strong> de acesso e acesse
                                o:
                                <Link
                                    :href="route('login')"
                                    class="text-base text-white bg-blue-500 py-2 px-4 rounded-md w-auto"
                                    >Login
                                </Link>
                            </p>
                        </template>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</template>
