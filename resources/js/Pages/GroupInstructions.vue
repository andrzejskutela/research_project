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

        <p class="text-xl my-6 text-justify px-8">I want you to play a simple memory game. On your phones, you will be shown a single, positive image and all you need to do is tap, or click it. Once you do so,
        the same image will appear on the list accompanied with another image in similar theme. I want you to select the <span class="italic">*new*</span> image that you have not seen before.
        Each time you select the correct image, one new similar image will be added to the list. This will continue, until either,
        you correctly select all the newly-added images, or make a mistake.
        Remember to always select the image that has <span class="italic">*not*</span> yet been shown to you.</p>
        <p class="text-xl my-6 text-justify px-8">On your phones you will have the opportunity to familiarise yourself with the game and prepare for the memory test.
        You will be presented with a list of five flower images. Please select them in a way described above. Once you complete the initial introductory task, you will be given the actual memory test.</p>
        <p class="text-xl my-6 text-justify px-8">Please remain silent until the experiment is finished, and do not refresh any page or go back, as this will invalidate your results.</p>
        <div class="py-6 mx-12 text-right">
            <fwb-button gradient="blue" :href="data.continue_link" class="text-lg">Next</fwb-button>
        </div>
    </AuthenticatedLayout>
</template>
