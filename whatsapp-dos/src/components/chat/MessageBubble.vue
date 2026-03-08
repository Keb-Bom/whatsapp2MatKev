<template>
  <div :class="isOwn ? 'flex justify-end' : 'flex justify-start'">

    <div
      :class="[
        'px-4 py-2 rounded-lg max-w-xs text-sm shadow',
        isOwn
          ? 'bg-[#005c4b] text-white rounded-br-none'
          : 'bg-[#202c33] text-white rounded-bl-none'
      ]"
    >

      {{ message }}

      <div class="text-[10px] text-gray-300 mt-1 text-right">
        {{ time }}
      </div>

    </div>

  </div>
</template>

<script setup>

defineProps({
  message: String,
  isOwn: Boolean,
  time: {
    type:String,
    default:""
  }
})

</script>