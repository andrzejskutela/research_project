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
    <p class="my-4 text-justify text-xl">You are welcome to share this study with friends and family members. It will help gather more data and improve the validity of the study.
    To do so, just share the link below, but please don't mention the details of the study as this will drive unncecessary expectations. Just mention it's a study on visual short-term memory.
    Once again thank you for your help. If you wish to contact me directly you can do so <a class="underline decoration-dashed text-sky-600" href="mailto:apskutela@gmail.com">&nbsp;HERE&nbsp;</a>.</p>
    <p class="my-4 text-justify text-xl">Data collection part of this study will end on 25/02/2025.</p>
    <p class="my-6 py-6 text-4xl text-center">{{ data.app_url }}</p> 
  </Layout>
</template>
