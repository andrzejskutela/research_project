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
    <p>gender</p>
    <p>age</p>
    <p>meditation experience</p>
    <p>save button and follow to next page - info about what's going to happen</p>
    <p class="text-italic">perhaps it's worth calling this website header - impact of attention on visual short-term memory, instead
      of meditation. This way the control group is not going to know immediately that they are in control group. Also the questions 
    could be posted at the end instead of start. Also ask people to wear headphones, etc.</p>
    <fwb-button gradient="green" :href="data.continue_link">Next</fwb-button>
  </Layout>
</template>
