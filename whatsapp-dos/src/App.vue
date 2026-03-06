<template>
  <div class="h-screen w-screen bg-[#111b21] flex">

    <!-- Sidebar -->
    <ChatSidebar
      :selectedChat="selectedChat"
      @selectChat="selectChat"
      class="hidden md:flex"
    />

    <!-- Chat Window -->
    <ChatWindow
      v-if="selectedChat"
      :chat="selectedChat"
      @back="selectedChat = null"
      class="flex-1"
    />

    <!-- Placeholder si no hay chat seleccionado -->
    <div
      v-else
      class="flex-1 hidden md:flex items-center justify-center bg-[#222e35] text-gray-400 text-xl"
    >
      Selecciona un chat
    </div>

  </div>
</template>

<script setup>
import { ref } from "vue"
import ChatSidebar from "./components/chat/ChatSidebar.vue"
import ChatWindow from "./components/chat/ChatWindow.vue"

const selectedChat = ref(null)

const selectChat = (chat) => {
  selectedChat.value = chat
}
</script>