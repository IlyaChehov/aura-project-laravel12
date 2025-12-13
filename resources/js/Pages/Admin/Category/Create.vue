<template>
    <form @submit.prevent="storeCategory">
        <div>
            <!-- Заголовок и кнопки -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-[var(--main-text-color)]">Создание новой категории</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Заполните информацию о новой категории</p>
                </div>
                <div class="flex gap-3">
                    <Link :href="route('admin.categories.index')" class="px-4 py-2 border border-[var(--main-border-color)] text-[var(--main-text-color)] rounded-lg font-medium hover:bg-[var(--second-bg-color)] transition-colors flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                        </svg>
                        Назад
                    </Link>
                    <button type="submit" class="px-4 py-2 bg-[var(--accent-color)] text-[var(--second-text-color)] rounded-lg font-medium hover:opacity-90 transition-opacity flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        Сохранить категорию
                    </button>
                </div>
            </div>

            <div class="bg-[var(--second-bg-color)] rounded-xl shadow-sm p-6">
                <div class="space-y-6">
                    <div class="flex flex-col gap-1">
                        <label class="block text-sm font-medium text-[var(--main-text-color)] mb-2">
                            Название категории *
                        </label>
                        <InputText
                            v-model="form.title"
                            type="text"
                            placeholder="Введите название категории..."
                            class="w-full"
                            :class="{ 'p-invalid': errors.title }"
                        />
                        <Message v-show="errors.title" severity="error" variant="simple" size="small">{{ getErrorMessage('title') }}</Message>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Максимум 255 символов</p>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="block text-sm font-medium text-[var(--main-text-color)] mb-2">
                            Slug (URL)
                        </label>
                        <InputText
                            v-model="form.slug"
                            type="text"
                            placeholder="category-slug"
                            class="w-full"
                            :class="{ 'p-invalid': errors.slug }"
                        />
                        <Message v-show="errors.slug" severity="error" variant="simple" size="small">{{ getErrorMessage('slug') }}</Message>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Только латинские буквы, цифры и дефисы</p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { InputText, Message } from "primevue";
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";

defineOptions({
    layout: AdminLayout
});

const form = ref({
    title: '',
    slug: ''
});

const errors = ref({});

const storeCategory = async () => {
    try {
        const res = await axios.post(route('admin.categories.store'), form.value);
        console.log(res);
    } catch (err) {
        errors.value = err.response.data.errors;
    }
};

const getErrorMessage = (field) => {
    const message = errors.value[field];
    return Array.isArray(message) ? message[0] : message;
}

</script>
