<script setup>
import { Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import Pagination from '@/Components/Pagination.vue'

const sortTitle = ref('');

const emit = defineEmits(['update-sort', 'change-page']);

const sortColumn = (column) => {
    if(sortTitle.value === '') {
        sortTitle.value = 'desc';
    } else {
        sortTitle.value = sortTitle.value === 'desc' ? 'asc' : 'desc';
    }

    let values = {title: sortTitle.value};

    emit('update-sort', values);
}

const deletePost = (id) => {
    emit('delete-post', id)
}

const changePage = (page) => {
    emit('change-page', page);
}

const pages = () => {
    const result = [];

    if(props.datas.last_page < 6) {
        for (let i = 1; i <= props.datas.last_page; i++) {
            result.push(i);
        }
        return result;
    } else {
        if(props.datas.current_page < 5) {
            return [1, 2, 3, 4, 5];
        }

        if(props.datas.current_page > 4 && props.datas.current_page <= props.datas.last_page) {
            let itr = 4;
            if(props.datas.current_page != props.datas.last_page) {
                result.push(props.datas.current_page + 1);
                result.push(props.datas.current_page);
                itr = 3
            } else {
                result.push(props.datas.current_page);
            }

            for (let i = 1; i <= itr; i++) {
                result.push(props.datas.current_page - i);
            }

            return result.reverse();
        }
    }
    return [1, 2]
}

const props = defineProps({
    datas: {
        type: Object,
        default: [],
    }
});

</script>

<template>
    <div class="w-full">
        <div class="rounded mb-6 relative overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-white uppercase bg-blue-800">
                    <tr>
                        <th scope="col" class="px-6 py-3">

                        </th>
                        <th scope="col" class="px-6 py-3 cursor-pointer flex items-center" @click="sortColumn()">
                            Title
                            <svg v-if="sortTitle === 'asc'" viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="text-white w-5 h-5"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg>
                            <svg v-else viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="text-white w-5 h-5"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>
                        </th>
                        <th scope="col" class="px-6 py-3 cursor-pointer">
                            Date Publish
                        </th>
                        <th scope="col" class="px-6 py-3">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="data in props.datas.data" :key="data.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-blue-100 cursor-pointer">
                        <th scope="row" class="px-6 py-2 font-medium whitespace-nowrap">
                            {{ data.id }}
                        </th>
                        <td class="px-6 py-2">
                            <p class="truncate w-1/2">
                                {{ data.title }}
                            </p>
                        </td>
                        <td class="px-6 py-2">
                            {{ data.created_at }}
                        </td>
                        <td class="px-6 py-2 flex space-x-2 justify-end">
                            <Link :href="route('post.show', data.slug)" class="bg-custom-primary hover:bg-custom-secondary text-blue-800 font-bold text-xs py-1 px-2 rounded">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </Link>
                            <button @click="deletePost(data.slug)" class="bg-custom-primary hover:bg-custom-secondary text-red-500 font-bold text-xs py-1 px-2 rounded">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div v-if="props.datas.data?.length === 0" class="w-full flex justify-center">
                <div class="py-20">
                    <div class="flex-col text-center">
                        <i class="fas fa-triangle-exclamation text-8xl text-custom-primary"></i>
                        <p class="text-custom-primary mt-2 text-xl">No data to show</p>
                    </div>
                </div>
            </div>
        </div>
        <Pagination :datas="props.datas" :pages="pages()" @change-page="changePage"></Pagination>
    </div>
</template>
