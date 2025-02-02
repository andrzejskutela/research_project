<script setup>
import Layout from './Layout.vue'
import { Head } from '@inertiajs/vue3'

import { FwbButton } from 'flowbite-vue'

defineProps({ data: Object })
</script>

<template>
  <Layout>
    <Head title="Cognitive Psychology Research Project" />
    <h1 class="text-center text-2xl pb-2">Impact of Different Preparation Methods on Visual Short-term Memory</h1>
    <p>at this point I know intervention vs control, this is very audio is played</p>
    <fwb-button gradient="green" :href="data.continue_link">Ready</fwb-button>
  </Layout>
</template>
