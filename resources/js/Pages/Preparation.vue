<script setup>
import Layout from './Layout.vue'
import { ref, useTemplateRef } from 'vue'
import { Head } from '@inertiajs/vue3'

import { FwbModal, FwbButton, FwbProgress } from 'flowbite-vue'

const { data } = defineProps({ data: Object })

const player = useTemplateRef('audio-player')
const showModal = ref(false)
const showButton = ref(true)
const audioProgress = ref(0)

function startPlayer() {
  player.value.volume = 0.8
  let interval = setInterval(function () {
    const duration = player.value.duration
    const current = player.value.currentTime

    audioProgress.value = Math.round(100 * current / duration)
  }, 500)

  player.value.addEventListener('ended', function () {
    audioProgress.value = 100
    showModal.value = true
    clearInterval(interval)
  })

  player.value.play()
  showButton.value = false
}

function continueNextUrl() {
  window.location.href = data.continue_link
}
</script>

<template>
  <Layout>
    <Head title="Cognitive Psychology Research Project" />
    <h1 class="text-center text-2xl pb-2">Impact of Preparation on Visual Short-term Memory</h1>
    <p class="text-xl my-6 text-justify">Now is the preparation step. Below is a button that controls the audio I want you to play and listen to.
    Please listen to it in a quiet environment, preferrably on headphones, however any audio system will work.</p>
    <p class="text-xl my-6 text-justify">This audio recording will guide you through some simple meditation technique.
    Please pay attention and follow the simple instructions.</p>
    <p class="text-xl my-6 text-justify">When the recording gently comes to an end you will be able to navigate to the final memory task.</p>
    <div class="my-6 text-center">
      <audio :src="data.audio_uri" preload="auto" ref="audio-player"></audio>
      <fwb-button gradient="green" @click="startPlayer" class="text-4xl" v-if="showButton">&#9658; Play</fwb-button>
      <fwb-progress v-if="!showButton" size="sm" color="green" :progress="audioProgress"></fwb-progress>
    </div>

    <fwb-modal v-if="showModal" @close="continueNextUrl" persistent>
        <template #header>
          <div class="flex items-center text-lg">
            Preparation
          </div>
        </template>
        <template #body>
          <p class="text-base leading-relaxed">
            You have completed this section. Please tap or click the button below to be taken to the memory task.
          </p>
        </template>
        <template #footer>
          <div class="flex justify-between">
            <fwb-button @click="continueNextUrl" color="green">
              Continue
            </fwb-button>
          </div>
        </template>
      </fwb-modal>
  </Layout>
</template>
