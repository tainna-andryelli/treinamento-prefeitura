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
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header>
                    <div class="flex lg:justify-center lg:col-start-2">
                        <img
                            class="h-24 w-auto my-8"
                            src="https://upload.wikimedia.org/wikipedia/commons/f/fd/Bras%C3%A3o_de_S%C3%A3o_Leopoldo_-_RS.svg"
                        />
                    </div>
                    <nav
                        v-if="canLogin"
                        class="-mx-3 flex flex-1 justify-center"
                    >
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('home')"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Home
                        </Link>

                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Log in
                            </Link>

                            <!-- <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Register
                            </Link> -->
                        </template>
                    </nav>
                </header>

                <main class="mt-6"></main>

                <footer
                    class="py-16 text-center text-sm text-black dark:text-white/70"
                ></footer>
            </div>
        </div>
    </div>
</template>
