<script setup>
import Layout from './Layout.vue'
import MemoryGame from '../Components/MemoryGame.vue'
import { Head } from '@inertiajs/vue3'

import { FwbButton } from 'flowbite-vue'

defineProps({ data: Object })
</script>

<template>
  <Layout>
    <Head title="Cognitive Psychology Research Project" />
    <h1 class="text-center text-2xl pb-2">Impact of Different Preparation Methods on Visual Short-term Memory</h1>
    <MemoryGame :data="data"></MemoryGame>
  </Layout>
</template>
