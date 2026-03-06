<template>
  <div class="p-4 bg-[#202c33] flex items-center gap-3">
    <input
      v-model="text"
      type="text"
      placeholder="Escribe un mensaje"
      class="flex-1 p-3 rounded-lg bg-[#2a3942] text-white outline-none"
    />
    <button
      class="bg-[#00a884] px-4 py-2 rounded-lg text-white font-semibold hover:opacity-80 transition"
      @click="send"
    >
      Enviar
    </button>
  </div>
</template>

<script setup>
import { ref } from "vue"

const text = ref("")

const send = () => {
  if (!text.value) return
  text.value = ""
}
</script>