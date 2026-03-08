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
      class="flex-1 overflow-y-auto p-6 space-y-3 bg-[url('https://previews.123rf.com/images/mangpor2004/mangpor20041712/mangpor2004171200032/91596965-blank-green-grunge-cement-wall-texture-background-banner-interior-design-background.jpg')] bg-cover"
    >

      <MessageBubble
        v-for="msg in messages"
        :key="msg.id"
        :message="msg.text"
        :isOwn="msg.isOwn"
      />

      <!-- BOT TYPING -->
      <div
        v-if="botTyping"
        class="text-gray-300 text-sm bg-[#202c33] px-3 py-2 rounded-lg w-fit"
      >
        Bot está escribiendo...
      </div>

    </div>

    <!-- Input -->
    <MessageInput @send="sendMessage"/>

  </div>
</template>

<script setup>

import { ref, watch, onMounted } from "vue"

import MessageBubble from "./MessageBubble.vue"
import MessageInput from "./MessageInput.vue"

import { getMessages, sendMessage as sendApiMessage } from "../../services/messageService"
import { markMessagesAsRead } from "../../services/messageService"

const props = defineProps({
  chat: Object
})

const messages = ref([])
const botTyping = ref(false)

const userId = localStorage.getItem("user_id")

// cargar mensajes
const loadMessages = async () => {

  if(!props.chat) return

  const data = await getMessages(props.chat.id)

  await markMessagesAsRead(props.chat.id)

  messages.value = data.map(m => ({
    id: m.id,
    text: m.message_encrypted,
    isOwn: m.sender_id == userId
  }))

}

// enviar mensaje
const sendMessage = async (text) => {

  if(!text) return

  // si es el bot
  if(props.chat.id == 4){
    botTyping.value = true
  }

  await sendApiMessage(props.chat.id, text)

  await loadMessages()

  // esperar respuesta del bot
  if(props.chat.id == 4){

    setTimeout(async () => {

      await loadMessages()

      botTyping.value = false

    },1200)

  }

}

// cuando cambie el chat
watch(() => props.chat, () => {
  loadMessages()
})

// al iniciar
onMounted(() => {

  loadMessages()

  // actualización automática (pseudo tiempo real)
  setInterval(loadMessages, 2000)

})

</script>