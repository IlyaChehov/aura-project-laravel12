<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { ref, watch } from "vue";
import { useToast, Toast } from "primevue";
import { Link } from "@inertiajs/vue3";

defineOptions({
    layout: AdminLayout
});

const props = defineProps({
    categories: Object
});

const categoriesData = ref(props.categories?.data || []);
const entries = ref({
    filter: {
        id: '',
        title: '',
        slug: '',
    },
    pagination: {
        per_page: '',
        page: 1
    }
});

watch(entries.value.filter, () => {
    entries.value.pagination.page = 1;
    getCategories();
}, {
    deep: true
});

watch(entries.value.pagination, () => {
    getCategories();
}, {
    deep: true
});

const toast = useToast();
const showMessage = (severity, summary, detail) => {
    toast.add({
        severity,
        summary,
        detail,
        life: 3000
    });
};

const deleteCategory = async (slug) => {
    try {
        const res = await axios.delete(route('admin.categories.destroy', slug));
        categoriesData.value = categoriesData.value.filter(cat => cat.slug !== slug);
        showMessage('success', 'Успешно!', 'Категория удалена');
    } catch (err) {
        showMessage('error', 'Ошибка!', 'Попробуйте позже...');
    }
};

const getCategories = async () => {
    try {
        const res = await axios.get(route('admin.categories.index'), {
            params: entries.value
        });
        categoriesData.value = res.data.data;

    } catch (err) {
        console.log(err);
    }
};

const clearFilter = () => {
    Object.assign(entries.value.filter, {
        id: '',
        title: '',
        slug: '',
    });
};

const setPage = (page) => {
    entries.value.pagination.page = page;
};

const prevPage = () => {
    if (entries.value.pagination.page > 1) {
        entries.value.pagination.page -= 1;
    }
};

const nextPage = () => {
    if (entries.value.pagination.page < props.categories.meta.last_page) {
        entries.value.pagination.page += 1;
    }
};

</script>

<template>
    <div>
        <Toast position="bottom-right" />
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-[var(--main-text-color)]">Управление категориями</h1>
            <div class="flex gap-3">
                <Link :href="route('admin.categories.create')" class="px-4 py-2 bg-[var(--accent-color)] text-[var(--second-text-color)] rounded-lg font-medium hover:opacity-90 transition-opacity flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Новая категория
                </Link>
            </div>
        </div>

        <div  class="bg-[var(--second-bg-color)] rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-600 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex gap-1 ml-auto">
                    <button @click="prevPage"
                    class="px-3 py-1 rounded-md bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-500 transition-colors">
                        Назад
                    </button>
                    <button
                        v-for="link in categories.meta.links.slice(1, -1)"
                        :class="[entries.pagination.page === link.page
                        ? 'bg-[var(--accent-color)] text-[var(--second-text-color)]'
                        : 'bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-500 transition-colors']"
                        v-html="link.label"
                        @click="setPage(link.page)"
                        class="px-3 py-1 rounded-md"
                    />
                    <button @click="nextPage"
                        class="px-3 py-1 rounded-md bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-500 transition-colors">
                        Вперед
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-600">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            <div class="flex items-center gap-2">
                                <span>ID</span>
                                <button class="text-gray-400 hover:text-[var(--accent-color)] transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                    </svg>
                                </button>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Название
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Slug
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Действия
                        </th>
                    </tr>

                    <tr class="bg-gray-50 dark:bg-gray-700/30 border-b border-gray-200 dark:border-gray-600">
                        <td class="px-6 py-3">
                            <input
                                v-model="entries.filter.id"
                                type="text"
                                placeholder="ID..."
                                class="w-full px-3 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-600 text-[var(--main-text-color)] focus:outline-none focus:ring-1 focus:ring-[var(--accent-color)] focus:border-transparent"
                            >
                        </td>
                        <td class="px-6 py-3">
                            <input
                                v-model="entries.filter.title"
                                type="text"
                                placeholder="Поиск по названию..."
                                class="w-full px-3 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-600 text-[var(--main-text-color)] focus:outline-none focus:ring-1 focus:ring-[var(--accent-color)] focus:border-transparent"
                            >
                        </td>
                        <td class="px-6 py-3">
                            <input
                                v-model="entries.filter.slug"
                                type="text"
                                placeholder="Поиск по slug..."
                                class="w-full px-3 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-600 text-[var(--main-text-color)] focus:outline-none focus:ring-1 focus:ring-[var(--accent-color)] focus:border-transparent"
                            >
                        </td>
                        <td class="px-6 py-3">
                            <button @click="clearFilter" class="w-full px-3 py-1 text-sm bg-gray-200 dark:bg-gray-500 text-[var(--main-text-color)] rounded-md hover:bg-gray-300 dark:hover:bg-gray-400 transition-colors">
                                Сбросить
                            </button>
                        </td>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">

                    <tr
                        v-for="category in categoriesData"
                        :key="category.id"
                        class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-[var(--main-text-color)]">
                            {{ category.id }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-[var(--main-text-color)]">
                                {{ category.title }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                15 постов
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--main-text-color)]">
                            {{ category.slug }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center gap-2">
                                <button class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 transition-colors p-1 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                    </svg>
                                </button>
                                <button
                                    @click="deleteCategory(category.slug)"
                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors p-1 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</template>
