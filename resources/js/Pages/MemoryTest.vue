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
    <p>memory test</p>
    <pre class="whitespace-pre p4 border-2 border-color-300 border-solid">{{ data }}</pre>
    <fwb-button gradient="green" :href="data.continue_link">Next</fwb-button>
  </Layout>
</template>
