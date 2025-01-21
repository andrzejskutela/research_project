<script setup>
import Layout from './Layout.vue'
import { Head } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import { FwbButton } from 'flowbite-vue'

const { data } = defineProps({ data: Object })
let currentSetIndex = ref(0);
let currentPicture = ref(0);
let correctAnswers = ref(0);

const showImages = computed(() => {
  let allowedImages = [];
  let currentSet = data.order[currentSetIndex.value]
  const sortRules = data.displayRules[currentPicture.value].split(',');
  for (let i = 0; i < currentPicture.value + 1 && i < 40; i++) {
    allowedImages.push({ i: i, src: data.images[currentSet][i] });
  }

  allowedImages.sort((a, b) => {
    if (sortRules[a.i] > sortRules[b.i]) {
      return 1;
    }

    return -1;
  });

  return allowedImages;
})

function select(item) {
  let currentSet = data.order[currentSetIndex.value]
  if (currentPicture.value < data.images[currentSet].length) {
    window.scrollTo({
      top: 0,
      left: 0,
      behavior: "smooth",
    });

    if (item === currentPicture.value) {
      currentPicture.value += 1;
      correctAnswers.value += 1;
    } else {
      alert('wrong answer!')

      if (currentSetIndex.value < data.order.length - 1) {
        currentSetIndex.value += 1
        currentPicture.value = 0
        correctAnswers.value = 0
      } else {
        alert('finished all sets')
      }
    }
  } else {
    alert('end of the set')
  }
}

</script>

<template>
  <Layout>
    <Head title="Psychology Research Project" />
    <h1 class="text-center text-2xl mb-8">Impact of Mindfulness Meditation on Visual Short-term Memory</h1>
    <p class="text-2xl sticky top-0 left-0 bg-white border-b-2 border-solid border-color-300 py-4 z-10">
      <span>Select the newly added image: </span>
      <span class="text-green-500">{{ correctAnswers }} correct answers</span>
    </p>
      <ul class="">
        <TransitionGroup name="fade-shuffle" tag="ul" :duration="400">
          <li v-for="item,index in showImages" :key="item" class="display-block py-8 my-4 border-2 border-color-300 border-solid bg-gray-100 mx-8 relative cursor-pointer" @click="select(item.i)">
            <img :src="item.src" class="m-auto" width="260">
            <span class="display-block absolute top-2 left-2 text-3xl text-slate-400">{{ index + 1 }}</span>
          </li>
        </TransitionGroup>
      </ul>
    <fwb-button gradient="green" :href="data.continue_link">Next</fwb-button>
  </Layout>
</template>
