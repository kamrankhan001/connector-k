<script setup>
    import {
        Head,
        Link
    } from '@inertiajs/vue3';
    import GuestLayout from '@/Layouts/GuestLayout.vue';
</script>

<template>

    <Head title="Welcome" />

    <GuestLayout>
        <div class="text-center">
            <h1 class="text-balance text-5xl font-semibold tracking-tight text-gray-900 sm:text-7xl">
                Connect with <br><span class="text-indigo-600">Like Minded</span> People
            </h1>
            <p class="mt-8 text-pretty text-lg font-medium text-gray-500 sm:text-xl/8">
                Connector K is your platform to discover and connect with people who share your interests and
                passions. Build meaningful relationships, share experiences, and grow together in a supportive
                community.
            </p>
            <div class="mt-10 flex items-center justify-center gap-x-6">
                <Link :href="route('login')"
                    class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Get Started
                </Link>
            </div>
        </div>
    </GuestLayout>
</template>
