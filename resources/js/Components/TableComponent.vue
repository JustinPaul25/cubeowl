<script setup>
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import Pagination from '@/Components/Pagination.vue'

const sortTitle = ref('asc');

const emit = defineEmits(['update-sort', 'change-page']);

const sortColumn = (column) => {
    if(column === 'title') {
        sortDoc.value = ''
        if(sortTitle.value === '') {
            sortTitle.value = 'desc';
        } else {
            sortTitle.value = sortTitle.value === 'desc' ? 'asc' : 'desc';
        }
    }

    let values = {name: sortTitle.value};

    emit('update-sort', values);
}

const changePage = (page) => {
    emit('change-page', page);
}

const pages = () => {
    const result = [];

    if(props.cages.last_page < 6) {
        for (let i = 1; i <= props.cages.last_page; i++) {
            result.push(i);
        }
        return result;
    } else {
        if(props.cages.current_page < 5) {
            return [1, 2, 3, 4, 5];
        }

        if(props.cages.current_page > 4 && props.cages.current_page <= props.cages.last_page) {
            let itr = 4;
            if(props.cages.current_page != props.cages.last_page) {
                result.push(props.cages.current_page + 1);
                result.push(props.cages.current_page);
                itr = 3
            } else {
                result.push(props.cages.current_page);
            }

            for (let i = 1; i <= itr; i++) {
                result.push(props.cages.current_page - i);
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
                        <th scope="col" class="px-6 py-3 cursor-pointer flex items-center" @click="sortColumn('title')">
                            Title
                            <svg v-if="sortTitle === 'asc'" viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="text-white"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg>
                            <svg v-else viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="text-white"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>
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
                        <td class="px-6 py-2">
                            {{ data.created_at }}
                        </td>
                        <!-- <td class="px-6 py-2 flex space-x-2 justify-end">
                            <button @click="viewReports(cage.slug)" class="bg-custom-primary hover:bg-custom-secondary text-white font-bold text-xs py-1 px-2 rounded">
                                <span><i class="fas fa-eye"></i></span>
                            </button>
                        </td> -->
                    </tr>
                </tbody>
            </table>
            <div v-if="props.datas.data?.length === 0" class="w-full flex justify-center">
                asdasdas
                <div class="py-20">
                    <div class="flex-col text-center">
                        <i class="fas fa-triangle-exclamation text-8xl text-custom-primary"></i>
                        <p class="text-custom-primary mt-2 text-xl">No data to show</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- <Pagination :cages="props.posts" :pages="pages()" @change-page="changePage"></Pagination> -->
    </div>
</template>
