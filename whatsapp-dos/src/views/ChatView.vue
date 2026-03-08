<template>
  <div class="h-screen w-screen flex">
    <ChatSidebar
      :selectedChat="selectedChat"
      @selectChat="selectChat"
      class="hidden md:flex"
    />

    <ChatWindow
      v-if="selectedChat"
      :chat="selectedChat"
      class="flex-1"
    />
  </div>
</template>

<script setup>
import { ref } from "vue"

import ChatSidebar from "../components/chat/ChatSidebar.vue"
import ChatWindow from "../components/chat/ChatWindow.vue"

const selectedChat = ref(null)

function selectChat(chat){
  selectedChat.value = chat
}
</script>