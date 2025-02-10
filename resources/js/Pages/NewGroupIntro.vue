<script setup>
import Layout from './Layout.vue'
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue'
import { FwbButton, FwbAlert } from 'flowbite-vue'

const data = defineProps({ data: Object })
const showError = ref(false)

function pressButton() {
  showError.value = false

  axios.post(data.data.check_link, {})
    .then(function (response) {
      if(response.data.allow_next_step === true) {
        window.location.href = data.data.continue_link
      }
      else {
        showError.value = true
      }
    })
    .catch(function (error) {
      showError.value = true
      // console.log(error);
    });
}
</script>

<template>
  <Layout>
    <Head title="Cognitive Psychology Research Project" />
    <h1 class="text-center text-2xl pb-2">Impact of Preparation on Visual Short-term Memory</h1>
    <p class="text-xl my-6 text-justify">Please observe the main screen and press or tap the button below when instructed.</p>
    <fwb-alert type="danger" v-if="showError" class="text-xl">Task is not ready yet.</fwb-alert>
    <div class="text-center my-8">
      <fwb-button gradient="green" @click="pressButton" class="text-lg">Start</fwb-button>
    </div>
  </Layout>
</template>
