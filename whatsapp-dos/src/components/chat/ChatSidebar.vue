<template>
  <div class="w-full md:w-[400px] bg-[#111b21] text-white flex flex-col">

    <!-- Header -->
    <div class="p-4 bg-[#202c33] flex justify-between items-center">
      <div class="font-semibold">WhatsApp Dos</div>
    </div>

    <!-- Search -->
    <div class="p-3 bg-[#111b21]">
      <input
        type="text"
        placeholder="Buscar chat..."
        class="w-full p-2 rounded-lg bg-[#202c33] text-white outline-none"
      />
    </div>

    <!-- Chat list -->
    <div class="flex-1 overflow-y-auto">
      <div
        v-for="chat in chats"
        :key="chat.id"
        @click="$emit('selectChat', chat)"
        class="p-4 hover:bg-[#202c33] cursor-pointer border-b border-[#222e35] transition"
      >
        <div class="font-semibold">{{ chat.name }}</div>
        <div class="text-sm text-gray-400 truncate">
          {{ chat.lastMessage }}
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
const chats = [
  { id: 1, name: "Juan Pérez", lastMessage: "Hola bro!" },
  { id: 2, name: "Ana López", lastMessage: "¿Ya viste eso?" },
  { id: 3, name: "Carlos", lastMessage: "Nos vemos mañana." }
]
</script>