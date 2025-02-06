<script setup>
import { Head } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import { FwbModal, FwbButton } from 'flowbite-vue'

const { data } = defineProps({ data: Object })
const isGameFinished = ref(false)
let currentSetIndex = ref(0);
let currentPicture = ref(0);
let correctAnswers = ref(0);
let showModal = ref(false)
let currentDisplaySet = ref(data.order[currentSetIndex.value]);
let setTimer = 0
let uploadTimer = []
let allowExit = false

window.addEventListener("beforeunload", function (e) {
  if (allowExit === false && !window.confirm('Navigating back, refreshing, or closing this window will invalidate your participation. Do you want to continue?')) {
    e.preventDefault()
    e.returnValue = ''
  }
});

const showImages = computed(() => {
  let allowedImages = [];
  let currentSet = data.order[currentSetIndex.value]
  const sortRules = data.display_rules[currentPicture.value].split(',');
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

function registerTimer() {
  setTimer = performance.now()
}

function continueGame() {
  if (currentSetIndex.value < data.order.length - 1) {
      currentSetIndex.value += 1
      currentPicture.value = 0
      correctAnswers.value = 0
      currentDisplaySet.value = data.order[currentSetIndex.value]
      showModal.value = false
    } else {
      allowExit = true
      window.location.href = data.continue_link
    }
}

function select(item) {
  let currentSet = data.order[currentSetIndex.value]
  let isCorrect = null
  let isEndOfSet = false
  if (currentPicture.value < data.images[currentSet].length) {
    window.scrollTo({
      top: 0,
      left: 0,
      behavior: "smooth",
    });

    if (item === currentPicture.value) {
      uploadTimer.push(performance.now() - setTimer)
      correctAnswers.value += 1;
      isCorrect = true
    } else {
      isCorrect = false
    }
  }

  if (isCorrect === true) {
     if (currentPicture.value + 1 >= data.images[currentSet].length) {
        isEndOfSet = true
     } else {
        currentPicture.value += 1;
     }
  } 

  if (isCorrect === false || isEndOfSet === true) {
      let dataToSend = {
        uuid: data.uuid,
        set: currentDisplaySet.value,
        score: correctAnswers.value,
        timings: uploadTimer,
        reentry_flag: window.localStorage.getItem('meditation_research_visited')
      }

      axios.post(data.data_link, dataToSend)
      .then(function (response) {
        // console.log(response);
      })
      .catch(function (error) {
        // console.log(error);
      });

      showModal.value = true
  }
}

</script>

<template>
    <div>
      <p class="text-2xl sticky top-0 left-0 bg-white border-b-2 border-solid border-color-300 py-4 z-10">
        <span>Select the newly added image: </span>
        <span class="text-green-500">{{ correctAnswers }} correct answers</span>
      </p>
      <ul>
        <TransitionGroup name="fade-shuffle" tag="ul" @enter="registerTimer">
          <li v-for="item,index in showImages" :key="item" class="display-block py-8 my-4 border-2 border-color-300 border-solid bg-gray-100 mx-8 relative cursor-pointer" @click="select(item.i)">
            <img :src="item.src" class="m-auto" width="400">
            <span class="display-block absolute top-2 left-2 text-3xl text-slate-400">{{ index + 1 }}</span>
          </li>
        </TransitionGroup>
      </ul>

      <fwb-modal v-if="showModal" @close="continueGame" persistent>
        <template #header>
          <div class="flex items-center text-lg">
            Section completed
          </div>
        </template>
        <template #body>
          <p class="text-base leading-relaxed">
            You have completed this section. Your score is {{ correctAnswers }} correct answers.
          </p>
          <p v-if="data.display_control_info" class="my-4">You have now finished the preparation task and should be familiar with the system. When ready, please tap the button below and you will be shown
      the memory game three more times in the following order: nature landscapes, female faces, and male faces. Good luck.
          </p>
        </template>
        <template #footer>
          <div class="flex justify-between">
            <fwb-button @click="continueGame" color="green">
              Continue
            </fwb-button>
          </div>
        </template>
      </fwb-modal>
    </div>
</template>
