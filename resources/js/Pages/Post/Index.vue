<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { inject, onMounted, ref  } from 'vue'
import PostsTable from '@/Components/TableComponent.vue';
import { usePostsStore } from '@/Store/usePostStore';

const swal = inject('$swal');
const search = ref('');
const sortTitle = ref('');
const page = ref(1);
const store = usePostsStore();

const props = defineProps({
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

const generateParams = (search, title) => {
    return {
        page: page.value,
        search: search,
        sortTitle: title
    }
}

onMounted(() => {
    if(props.toast.type !== 'none') {
        Toast.fire({
            icon: props.toast.type,
            iconColor: '#1E40AF',
            title: props.toast.message
        })
    }
    store.fetchPosts(generateParams(search.value, 'asc'))
})
</script>

<template>
    <Head title="My Posts" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Posts</h2>
        </template>

        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between">
                <div class="w-1/2">
                    <p class="text-lg">
                        Create a post and share your thoughts into internet such as daily blog, technology, and anything what comes up in your mind!
                    </p>
                </div>
                <Link :href="route('post.create')" class="bg-blue-800 hover:bg-blue-400 text-white font-bold px-4 rounded flex items-center">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                    Create Post
                </Link>
            </div>
            <div class="mt-10">
                <PostsTable :datas="store.getPosts"></PostsTable>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
