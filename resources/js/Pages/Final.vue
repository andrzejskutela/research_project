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
    <p>final page, thank you for participantion, and maybe ask for email where in the end I can send out findings</p>
  </Layout>
</template>
