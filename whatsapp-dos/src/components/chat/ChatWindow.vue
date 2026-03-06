<template>
  <div class="flex flex-col h-screen bg-[#0b141a] w-full">

    <!-- Header -->
    <div class="p-4 bg-[#202c33] flex items-center gap-4 text-white">
      <button
        class="md:hidden text-gray-300"
        @click="$emit('back')"
      >
        ←
      </button>

      <div>
        <div class="font-semibold">{{ chat.name }}</div>
        <div class="text-xs text-gray-400">En línea</div>
      </div>
    </div>

    <!-- Messages -->
    <div
      class="flex-1 overflow-y-auto p-6 space-y-3 bg-[url('https://i.imgur.com/Dr6G6tA.png')] bg-cover"
    >
      <MessageBubble
        v-for="msg in messages"
        :key="msg.id"
        :message="msg.text"
        :isOwn="msg.isOwn"
      />
    </div>

    <!-- Input -->
    <MessageInput />

  </div>
</template>

<script setup>
import MessageBubble from "./MessageBubble.vue"
import MessageInput from "./MessageInput.vue"

defineProps({
  chat: Object
})

const messages = [
  { id: 1, text: "Hola!", isOwn: false },
  { id: 2, text: "Qué tal?", isOwn: false },
  { id: 3, text: "Todo bien 😎", isOwn: true }
]
</script>