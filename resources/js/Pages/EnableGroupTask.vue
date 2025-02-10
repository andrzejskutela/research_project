<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue'
import { FwbButton, FwbInput, FwbSelect } from 'flowbite-vue'

defineProps({ data: Object })
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Impact of Preparation on Visual Short-term Memory
            </h2>
        </template>

        <p class="text-xl my-6 text-justify px-8">Good luck</p>
    </AuthenticatedLayout>
</template>
