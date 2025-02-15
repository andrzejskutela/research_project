<script setup>
import Layout from './Layout.vue'
import { Head } from '@inertiajs/vue3'

import { FwbButton } from 'flowbite-vue'

defineProps({ data: Object })
</script>

<template>
  <Layout>
    <Head title="Cognitive Psychology Research Project" />
    <h1 class="text-center text-2xl pb-2">Impact of Preparation on Visual Short-term Memory</h1>
    <h1 class="text-center mt-8 text-4xl pt-4 pb-4">Thank you!</h1>
    <p class="my-6 text-justify text-xl">This study was designed to measure the impact of different preparation on visual short-term memory and you were randomly assingned
      to either the control or intervention group. Your participation is greatly apprieciated.</p>
    <p class="my-4 text-justify text-xl">If you wish to contact me directly you can do so <a class="underline decoration-dashed text-sky-600" href="mailto:apskutela@gmail.com">&nbsp;HERE&nbsp;</a>.</p>
    <p class="my-4 text-justify text-xl">Data collection part of this study will end on 25/02/2025.</p>
  </Layout>
</template>
