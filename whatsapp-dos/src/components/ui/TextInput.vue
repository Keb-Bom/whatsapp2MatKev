<template>
  <div class="flex flex-col gap-1 w-full">
    <label class="text-sm text-gray-300">{{ label }}</label>

    <input
      :type="type"
      v-model="model"
      class="p-3 rounded bg-[#2a3942] text-white outline-none"
    />

    <span v-if="error" class="text-red-400 text-xs">
      {{ error }}
    </span>
  </div>
</template>

<script setup>
import { computed } from "vue"

const props = defineProps({
  label: String,
  type: String,
  modelValue: String,
  error: String
})

const emit = defineEmits(["update:modelValue"])

const model = computed({
  get: () => props.modelValue,
  set: value => emit("update:modelValue", value)
})
</script>