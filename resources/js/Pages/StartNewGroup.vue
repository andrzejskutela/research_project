<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue'
import { FwbButton, FwbInput, FwbSelect } from 'flowbite-vue'

const { props } = defineProps({ data: Object })

let group_label = ref('')
let group_type = ref('')
const group_types = [
    { value: 'c', name: 'Control group' },
    { value: 'i', name: "Intervention group" },
]

function prcessNewGroup() {
    const dataToSend = {
        label: group_label.value,
        group: group_type.value
      }

      axios.post(props.new_group_link, dataToSend)
          .then(function (response) {
            if (response && response.data) {
              // register new group and redirect to new group page with instructions and qr code
            }
          })
          .catch(function (error) {
            
          });
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Impact of Preparation on Visual Short-term Memory
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 text-center">
                <img :src="data.qr_img" class="mx-auto">
                <p class="text-4xl">{{ data.full_link }}</p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
