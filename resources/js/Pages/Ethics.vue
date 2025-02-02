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
    <p class="text-xl my-6 text-justify">I want you to play a simple memory game. You will be shown a single, positive image and all you need to do is tap it, or click it. Once you do so,
    the same image will appear on the list accompanied with another image in similar theme. I want you to select the <span class="italic">*new*</span> image that you have not seen before. This will continue, until either,
    you successfuly select the newly-added image 40 times, or make a mistake. The score will always be shown to you and you will have 30 seconds each time to select an image.
    Remember to always select the image that has <span class="italic">*not*</span> yet been displayed to you.</p>
    <p class="text-xl my-6 text-justify">You will have three trials, each time with different set of images: male faces, female faces, and nature landscapes. The order in which
    you see these images is random. In the next page, you will have the opportunity to familiarise yourself with the system.
    You will be presented with the game, using a set of only three flower images.
    This trial is NOT part of the task, it is only there to show you how the actual task works. Once you familiarise yourself with the game, you will be redirected to the task's landing page.</p>
    <p class="text-xl my-6 text-justify">From this point on, please do not refresh the page or go back, as this will invalidate your results.</p>
    <p class="text-xl my-6 text-justify">If you wish to continue please tap, or click the button below. If you wish to withdraw, simply close this page.</p>
    <div class="text-center my-8">
      <fwb-button gradient="green" :href="data.continue_link" class="text-lg">I agree to continue</fwb-button>
    </div>
  </Layout>
</template>
