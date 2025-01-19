<script setup>
import { FwbDropdown, FwbListGroup, FwbListGroupItem } from 'flowbite-vue'
</script>

<template>
  <main class="container mx-auto border-2 border-black border-solid mt-8 bg-white p-6">
    <fwb-dropdown text="Click me" placement="top">
    <fwb-list-group>
      <fwb-list-group-item>Item #1</fwb-list-group-item>
      <fwb-list-group-item>Item #2</fwb-list-group-item>
      <fwb-list-group-item>Item #3</fwb-list-group-item>
    </fwb-list-group>
  </fwb-dropdown>
    <div>
      <article>
        <slot />
      </article>
    </div>
  </main>
</template>
