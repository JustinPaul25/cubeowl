<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const form = useForm({
    title: '',
    body: '',
    cover: null,
});

const submit = () => {
    form.post(route('post.store'), {
        onFinish: () => {
            form.reset('title')
            form.reset('body')
            form.reset('cover')
        },
    });
};
</script>

<template>
    <Head title="Create Post" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Post</h2>
        </template>

        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <form @submit.prevent="submit">
                <div class="mb-3">
                    <p  class="text-lg font-bold">Title</p>
                    <TextInput
                        id="title"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.title"
                        required
                        autofocus
                    />

                    <InputError class="mt-2" :message="form.errors.title" />
                </div>
                <div>
                    <p class="text-lg font-bold">Body</p>
                    <textarea
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        v-model="form.body"
                        id="body"
                        cols="30"
                        rows="10">
                    </textarea>

                    <InputError class="mt-2" :message="form.errors.body" />
                </div>

                <div class="flex">
                    <PrimaryButton class="mt-5 ml-auto flex" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1 mr-2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                        Publish Post
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
