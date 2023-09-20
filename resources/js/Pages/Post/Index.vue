<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { inject, onMounted, ref  } from 'vue'
import PostsTable from '@/Components/TableComponent.vue';
import { watchDebounced } from '@vueuse/core';
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

watchDebounced(search, () => {
    store.fetchPosts(generateParams(search.value))
}, {debounce: 500})

const generateParams = (search) => {
    return {
        page: page.value,
        search: search,
        sortTitle: sortTitle.value
    }
}

const updateSort = (values) => {
    sortTitle.value = values.title
    store.fetchPosts(generateParams(search.value))
}

const changePage = (newPage) => {
    page.value = newPage
    store.fetchPosts(generateParams(search.valuee))
}

const deletePost = (id) => {
    try {
        swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
        if (result.isConfirmed) {
                router.delete(route("post.destroy", id), {preserveScroll: true});
                Toast.fire({
                    icon: 'success',
                    iconColor: '#1E40AF',
                    title: 'Post deleted successfully!'
                })
                store.fetchPosts(generateParams(search.value))
            }
        })
    } catch (error) {
        Toast.fire({
            icon: 'error',
            iconColor: '#EF4444',
            title: 'Failed to delete post'
        })
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
    store.fetchPosts(generateParams(search.value))
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
            <div class="relative flex items-center w-full h-10 rounded bg-white overflow-hidden mt-8">
                <div class="grid place-items-center h-full w-12 bg-blue-800">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="text-white"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </div>

                <input
                v-model="search"
                class="h-full w-full outline-none text-sm text-gray-700 pr-2 border border-custom-primary rounded-r focus:border-custom-secondary"
                type="text"
                id="search"
                placeholder="Search Title Here" />
            </div>
            <div class="mt-5">
                <PostsTable :datas="store.getPosts" @update-sort="updateSort" @delete-post="deletePost" @change-page="changePage"></PostsTable>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
