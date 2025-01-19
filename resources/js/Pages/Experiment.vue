<script setup>
import Layout from './Layout.vue'
import { Head } from '@inertiajs/vue3'

import { FwbButton } from 'flowbite-vue'

defineProps({ data: Object })
</script>

<template>
  <Layout>
    <Head title="Psychology Research Project" />
    <h1 class="text-center text-lg">Impact of Mindfulness Meditation on Visual Short-term Memory</h1>
    <p>save button and follow to next page - info about what's going to happen</p>
    <p class="text-italic">Explanation of the task ahead.</p>
    <fwb-button gradient="green" :href="data.continue_link">Ready</fwb-button>
  </Layout>
</template>
