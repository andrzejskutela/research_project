<script setup>
import Layout from './Layout.vue'
import { Head } from '@inertiajs/vue3'

import { FwbButton } from 'flowbite-vue'

defineProps({ data: Object })
</script>

<template>
  <Layout>
    <Head title="Cognitive Psychology Research Project" />
    <h1 class="text-center text-4xl">Welcome</h1>
    <p class="text-lg my-4 text-justify">Thank you for visiting this website. Please read the following introductions carefully before proceding:</p>
    <p class="text-lg mb-4 text-justify">The following pages contain a short task designed to measure the capacity of your visual short-term memory in relation to a variable preparation.
    The exact instructions will be given in the next page, but before you continue I ask you to have 15 minutes of uninterupted time in a quiet environment.
    You can perform the task on your computer or tablet, altough phone is prefered. I also request you to have headphones ready for the audible part of the task.</p>
    <p class="text-lg mb-4 text-justify">The entire task will take no more than 15 minutes, and you retain the right to withdraw at any time.
    The research is conducted in line with current ethical guidelines of the British Psychological Society and you will come to no harm.</p>
    <p class="text-lg mb-4 text-justify">I hope you will be a willing participant and enjoy the task. Once the research is finished I am happy to share the findings with you if you wish so.</p>
    <div class="text-center my-8">
      <fwb-button gradient="green" :href="data.continue_link" class="text-lg">I want to participate</fwb-button>
    </div>
  </Layout>
</template>
