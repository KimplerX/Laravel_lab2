<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    products: Object,
});
</script>

<template>
    <Head title="Каталог товарів" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Всі товари</h2>
        </template>

        <template #default>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div v-for="product in products.data" :key="product.id" class="border p-4 rounded shadow-sm">
                                <h3 class="font-bold text-lg">{{ product.name }}</h3>
                                <p class="text-gray-600">Ціна: {{ product.price }} ₴</p>
                                <p class="text-sm mt-2" :class="product.is_active ? 'text-green-600' : 'text-red-600'">
                                    {{ product.is_active ? 'В наявності' : 'Немає' }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-between">
                            <Link v-if="products.prev_page_url" :href="products.prev_page_url" class="px-4 py-2 bg-blue-500 text-white rounded">Попередня</Link>
                            <span class="px-4 py-2" v-else></span>
                            
                            <Link v-if="products.next_page_url" :href="products.next_page_url" class="px-4 py-2 bg-blue-500 text-white rounded">Наступна</Link>
                        </div>

                    </div>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>