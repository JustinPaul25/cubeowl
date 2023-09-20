<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { inject, ref, onMounted  } from 'vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const swal = inject('$swal');
const onEdit = ref(false)

const toggleEdit = () => {
    onEdit.value = !onEdit.value
}

const props = defineProps({
    post: {
        type: Object
    },
    toast: {
        type: Object
    },
});

const Toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', swal.stopTimer)
        toast.addEventListener('mouseleave', swal.resumeTimer)
    }
})

const form = useForm({
    title: props.post.title,
    body: props.post.body
});

const submit = () => {
    form.patch(route('post.update', props.post.slug), {
        onFinish: (response) => {
            console.log(response)
            Toast.fire({
                icon: 'success',
                iconColor: '#1E40AF',
                title: 'Updated Successfully!'
            })
            onEdit.value = false
        },
    });
};

onMounted(() => {
    if(props.toast.type !== 'none') {
        Toast.fire({
            icon: props.toast.type,
            iconColor: '#1E40AF',
            title: props.toast.message
        })
    }
})
</script>

<template>
    <Head title="My Posts" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ props.post.title }}</h2>
        </template>

        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-end">
                <button v-if="!onEdit" @click="toggleEdit" class="bg-blue-800 hover:bg-blue-400 text-white font-bold px-4 h-10 rounded flex items-center">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                    Edit Post
                </button>
                <button v-else @click="toggleEdit" class="bg-red-500 hover:bg-red-400 text-white font-bold px-4 h-10 rounded flex items-center">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    Cancel Edit
                </button>
            </div>
            <div class="mt-5">
                <form @submit.prevent="submit">
                    <div class="mb-3">
                        <p  class="text-lg font-bold">Title</p>
                        <TextInput
                            :disabled = "!onEdit"
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
                            :disabled = "!onEdit"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            v-model="form.body"
                            id="body"
                            cols="30"
                            rows="10">
                        </textarea>

                        <InputError class="mt-2" :message="form.errors.body" />
                    </div>

                    <div v-if="onEdit" class="flex">
                        <PrimaryButton class="mt-5 ml-auto flex" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1 mr-2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                            Publish Updated Post
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
