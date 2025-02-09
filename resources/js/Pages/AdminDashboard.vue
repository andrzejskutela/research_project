<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue'
import { FwbButton, FwbInput, FwbSelect } from 'flowbite-vue'

let group_type = ref('')
const group_types = [
    { value: 'c', name: 'Control group' },
    { value: 'i', name: "Intervention group" },
]

function prcessNewGroup() {

}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Impact of Preparation on Visual Short-term Memory
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <fwb-select v-model="group_type" :options="group_types" label="Group type?" class="mb-4"/>
                        <fwb-button gradient="blue" @click="prcessNewGroup" class="text-lg">Start new group</fwb-button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
