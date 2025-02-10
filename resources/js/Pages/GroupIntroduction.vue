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
                Welcome!
            </h2>
        </template>

        <p class="text-xl mt-6 mb-6 text-justify px-8">
            I want to invite you to take part in a simple experiment designed to measure the impact of preparation on the capacity of visual short-term memory.
            The exact instructions will be given in the next page, but before you continue I ask you to have 15 minutes of uninterupted time in a quiet environment.
            You can perform the task on your computer or tablet, altough phone is preferred.
        </p>
        <p class="text-xl mb-6 text-justify px-8">To continue please scan the following qr code, or open the link below.
        </p>
        <p class="text-xl mb-6 text-justify px-8">The entire task should not take more than 15 minutes to complete, and you retain the right to withdraw at any time.
        The research is conducted in line with current ethical guidelines of the British Psychological Society and you will come to no harm.</p>
        <p class="text-xl mb-6 text-justify px-8">I hope you will be a willing participant and enjoy the task. Once the research is finished I am happy to share the findings with you if you wish so.</p>

        <div class="py-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 text-center">
                <img :src="data.qr_img" class="mx-auto">
                <p class="text-4xl">{{ data.full_link }}</p>
            </div>
        </div>
        <div class="py-6 mx-12 text-right">
            <fwb-button gradient="blue" :href="data.continue_link" class="text-lg">Next</fwb-button>
        </div>
    </AuthenticatedLayout>
</template>
