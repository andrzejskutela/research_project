<script setup>
import Layout from './Layout.vue'
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue'

import { FwbButton, FwbInput, FwbSelect } from 'flowbite-vue'

const { data } = defineProps({ data: Object })

let age = ref('')
let gender = ref('')
let email = ref('')
let meditation_experience = ref('')
let exercise_experience = ref('')
let coffee_experience = ref('')
let english_first_lang = ref('')
let errors = ref({
  age: '',
  gender: '',
  email: '',
  exercise: '',
  coffee: '',
  meditation_experience: '',
  english: '',
})

const genders = [
  { value: '1', name: 'female' },
  { value: '2', name: 'male' },
  { value: '3', name: "I don't want to say" },
]

const meditation_options = [
  { value: '1', name: 'None' },
  { value: '2', name: 'Some experience' },
  { value: '3', name: "I meditate regularly" },
]

const exercise_options = [
  { value: '1', name: 'No, sedentary lifestyle' },
  { value: '2', name: 'I exercise at least once a week' },
  { value: '3', name: "I exercise regularly" },
]

const coffee_options = [
  { value: '1', name: "No, I don't drink coffee" },
  { value: '2', name: 'I drink coffee at least once a week' },
  { value: '3', name: "I drink coffee everyday" },
]

const english_options = [
  { value: 'n', name: "No" },
  { value: 'y', name: 'Yes' },
]

function clearErrors() {
  for (let key in errors.value) {
      errors.value[key] = ''
    }
}

function processForm() {
  clearErrors()

  const dataToSend = {
    uuid: data.uuid,
    age: age.value,
    gender: gender.value,
    english: english_first_lang.value,
    email: email.value,
    meditation: meditation_experience.value,
    exercise: exercise_experience.value,
    coffee: coffee_experience.value
  }

  axios.post(data.form_link, dataToSend)
      .then(function (response) {
        if (response && response.data && response.data.continue_link) {
          window.localStorage.setItem('meditation_research_visited', 1)
          window.location.href = response.data.continue_link
        }
      })
      .catch(function (error) {
        if (error && error.response && error.response.data && error.response.data.errors) {
          for (let key in error.response.data.errors) {
            errors.value[key] = 'error'
          }
        }
      });
}

</script>

<template>
  <Layout>
    <Head title="Cognitive Psychology Research Project" />
    <h1 class="text-center text-2xl pb-2">Impact of Preparation on Visual Short-term Memory</h1>
    <p class="text-xl my-6 text-justify">Thank you very much for participating in the research. Your results have been recorded in the database.
    Before you close this window please provide your age, gender, and answers to the optional questions for the research processing. You may also provide your email address if you wish to be informed about the results of the research
    once it is concluded.</p>
    <div class="my-6 text-xl">
      <fwb-input v-model="age" required placeholder="age" label="Please provide your age" :validation-status="errors.age" type="number" class="mb-2"/>

      <fwb-select v-model="gender" :options="genders" label="Gender" :validation-status="errors.gender" class="mb-4"/>

      <fwb-select v-model="english_first_lang" :options="english_options" label="Is English your native language?" :validation-status="errors.english" class="mb-4"/>

      <fwb-select v-model="exercise_experience" :options="exercise_options" label="Do you exercise or live physically active life?" :validation-status="errors.exercise" class="mb-4"/>

      <fwb-select v-model="meditation_experience" :options="meditation_options" label="Do you have any experience with meditation?" :validation-status="errors.meditation_experience" class="mb-4"/>

      <fwb-select v-model="coffee_experience" :options="coffee_options" label="How often do you drink coffee?" :validation-status="errors.coffee" class="mb-4"/>

      <fwb-input v-model="email" required placeholder="email" label="Your email address if you would like to be notified about the research findings" :validation-status="errors.email" type="email" class="mb-4"/>
    </div>
    <fwb-button gradient="green" @click="processForm" class="text-lg">Submit data</fwb-button>
  </Layout>
</template>
