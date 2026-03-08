<template>
  <div
    class="p-3 rounded text-sm"
    :class="type === 'error'
      ? 'bg-red-500/20 text-red-300'
      : 'bg-green-500/20 text-green-300'"
  >
    {{ message }}
  </div>
</template>

<script setup>
defineProps({
  message: String,
  type: String
})
</script>