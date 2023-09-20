<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="bg-blue-800 rounded w-full py-20 flex flex-col items-center">
                <p class="text-center font-bold text-white mb-2">Last Assessment by:</p>
                <p class="text-center text-5xl font-bold text-white">Justin Paul Layan</p>
                <Link :href="route('post.index')" class="text-white flex mt-20 hover:opacity-75">
                    View Posts
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="text-white"><polyline points="13 17 18 12 13 7"></polyline><polyline points="6 17 11 12 6 7"></polyline></svg>
                </Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
