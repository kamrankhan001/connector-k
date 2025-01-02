<script setup>
    import { Link, usePage } from '@inertiajs/vue3';
</script>

<template>
    <h1 class="text-4xl font-semibold text-indigo-600">
        <Link :href="route('dashboard')" v-if="usePage().props.auth.user">Connector-K</Link>
        <Link :href="route('home')" v-else>Connector-K</Link>
    </h1>
</template>
