<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const form = useForm({
    name: '',
    price: '',
});

const submit = () => {
    form.post(route('products.store'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Додати товар" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Створення товару</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form @submit.prevent="submit" class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <div class="mb-4">
                        <label class="block font-medium">Назва товару</label>
                        <input v-model="form.name" type="text" class="w-full border-gray-300 rounded" required />
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium">Ціна</label>
                        <input v-model="form.price" type="number" class="w-full border-gray-300 rounded" required />
                    </div>
                    <button type="submit" :disabled="form.processing" class="px-4 py-2 bg-blue-600 text-white rounded">
                        Зберегти
                    </button>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>