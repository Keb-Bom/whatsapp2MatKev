<template>
  <div class="w-full md:w-[400px] bg-[#111b21] text-white flex flex-col">

    <!-- Header -->
    <div class="p-4 bg-[#202c33] flex justify-between items-center">
      <div class="flex flex-col">
        <span class="text-xs text-gray-400">Conectado como</span>
        <span class="font-semibold">
          {{ me?.name || "Cargando..." }}
        </span>
      </div>

      <!-- BOTON CERRAR SESION -->
      <button
        @click="logout"
        class="text-xs bg-red-500 hover:bg-red-600 px-3 py-1 rounded-lg transition"
      >
        Cerrar sesión
      </button>

    </div>

    <!-- Search -->
    <div class="p-3 bg-[#111b21]">
      <input
        v-model="search"
        type="text"
        placeholder="Buscar chat..."
        class="w-full p-2 rounded-lg bg-[#202c33] text-white outline-none"
      />
    </div>

    <!-- Chat list -->
    <div class="flex-1 overflow-y-auto">

      <div
        v-for="user in filteredUsers"
        :key="user.id"
        @click="$emit('selectChat', user)"
        class="p-4 hover:bg-[#202c33] cursor-pointer border-b border-[#222e35] transition flex justify-between"
      >

        <div class="flex flex-col">
          <div class="font-semibold">
            {{ user.name }}
          </div>

          <div class="text-sm text-gray-400 truncate">
            {{ user.lastMessage || "Sin mensajes aún" }}
          </div>
        </div>

        <div class="flex flex-col items-end">

          <div class="text-xs text-gray-400">
            {{ formatTime(user.lastTime) }}
          </div>

          <div
            v-if="user.unreadCount > 0"
            class="bg-[#00a884] text-xs px-2 py-1 rounded-full mt-1"
          >
            {{ user.unreadCount }}
          </div>

        </div>

      </div>

      <div v-if="filteredUsers.length === 0" class="p-4 text-center text-gray-400">
        No hay usuarios
      </div>

    </div>
  </div>
</template>

<script setup>

import { ref, onMounted, computed } from "vue"
import { getUsers } from "../../services/userService"
import { getMe } from "../../services/authService"

const users = ref([])
const search = ref("")
const me = ref(null)

const loadUsers = async () => {

  try {

    const data = await getUsers()

    if(Array.isArray(data)){
      users.value = data
    }else{
      console.error("Respuesta inesperada en /users:", data)
      users.value = []
    }

  } catch(err){

    console.error("Error cargando usuarios:", err)
    users.value = []

  }

}

const loadMe = async () => {

  try{

    const data = await getMe()

    me.value = data || null

  }catch(err){

    console.error("Error cargando usuario actual:", err)
    me.value = null

  }

}

const filteredUsers = computed(()=>{

  return (users.value || []).filter(u =>
    u?.name?.toLowerCase().includes(search.value.toLowerCase())
  )

})

const formatTime = (time)=>{

  if(!time) return ""

  const date = new Date(time)

  if(isNaN(date)) return ""

  return date.toLocaleTimeString([],{
    hour:"2-digit",
    minute:"2-digit"
  })

}

/* LOGOUT */
const logout = () => {

  localStorage.removeItem("token")
  localStorage.removeItem("user_id")

  window.location.href = "/"

}

onMounted(()=>{

  loadUsers()
  loadMe()

})

</script>