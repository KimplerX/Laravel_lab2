<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    cartItems: Array,
    calculations: Object,
});

const form = useForm({});

const submitOrder = () => {
    form.post(route('checkout.store'));
};
</script>

<template>
    <Head title="Оформлення замовлення" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Кошик та Розрахунок
            </h2>
        </template>

        <template #default>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div v-if="$page.props.flash.message" class="mb-4 p-4 bg-green-100 text-green-800 rounded border border-green-200">
                        {{ $page.props.flash.message }}
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                        <h3 class="text-lg font-bold mb-4">Ваші товари:</h3>
                        <ul class="mb-6 space-y-2">
                            <li v-for="item in cartItems" :key="item.id" class="border-b pb-2">
                                {{ item.name }} — {{ item.price }} ₴ ({{ item.quantity }} шт.)
                            </li>
                        </ul>

                        <div class="bg-gray-100 p-4 rounded text-lg">
                            <p><strong>Загальна сума:</strong> {{ calculations.total }} ₴</p>
                            <p><strong>ПДВ (20%):</strong> {{ calculations.tax }} ₴</p>
                            <p class="text-green-600"><strong>До сплати (зі знижкою 10%):</strong> {{ calculations.totalWithDiscount }} ₴</p>
                        </div>

                        <button 
                            @click="submitOrder"
                            :disabled="form.processing"
                            class="mt-6 px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 disabled:opacity-50"
                        >
                            {{ form.processing ? 'Обробка...' : 'Оформити замовлення' }}
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>