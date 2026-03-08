<template>
  <div class="h-screen flex items-center justify-center bg-[#111b21]">

    <div class="w-full max-w-md bg-[#202c33] p-8 rounded-xl space-y-5 shadow-lg">

      <h1 class="text-white text-2xl font-semibold text-center">
        Iniciar Sesión
      </h1>

      <div v-if="errorMessage" class="bg-red-500/20 text-red-300 p-3 rounded">
        {{ errorMessage }}
      </div>

      <div>
        <label class="text-gray-300 text-sm">Correo</label>
        <input
          v-model="email"
          type="email"
          class="w-full mt-1 p-2 rounded bg-[#2a3942] text-white outline-none"
        />
      </div>

      <div>
        <label class="text-gray-300 text-sm">Contraseña</label>
        <input
          v-model="password"
          type="password"
          class="w-full mt-1 p-2 rounded bg-[#2a3942] text-white outline-none"
        />
      </div>

      <button
        @click="login"
        class="w-full bg-[#00a884] hover:bg-[#019874] text-white py-2 rounded"
      >
        Ingresar
      </button>

      <p class="text-gray-400 text-center text-sm">
        ¿No tienes cuenta?

        <router-link
          to="/register"
          class="text-[#00a884] hover:underline"
        >
          Registrarse
        </router-link>
      </p>

    </div>

  </div>
</template>

<script setup>
import { ref } from "vue"
import { useRouter } from "vue-router"
import { loginUser } from "../services/authService"

const router = useRouter()

const email = ref("")
const password = ref("")
const errorMessage = ref("")

async function login(){

  errorMessage.value = ""

  if(!email.value || !password.value){
    errorMessage.value = "Debes completar todos los campos"
    return
  }

  try{

    const response = await loginUser({
      email: email.value,
      password: password.value
    })

    localStorage.setItem("session_id", response.session_id)
    localStorage.setItem("user_id", response.user_id)

    router.push("/chat")

  }
  catch(e){

    errorMessage.value = "Credenciales incorrectas"

  }

}
</script>