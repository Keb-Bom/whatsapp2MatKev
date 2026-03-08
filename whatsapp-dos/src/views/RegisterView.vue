<template>
  <div class="h-screen flex items-center justify-center bg-[#111b21]">

    <div class="w-full max-w-md bg-[#202c33] p-8 rounded-xl space-y-4 shadow-lg">

      <h1 class="text-white text-2xl text-center font-semibold">
        Crear Cuenta
      </h1>

      <div v-if="errorMessage" class="bg-red-500/20 text-red-300 p-3 rounded">
        {{ errorMessage }}
      </div>

      <div v-if="generatedPassword" class="bg-green-500/20 text-green-300 p-3 rounded text-center">
        Usuario creado 🎉 <br />
        Contraseña generada: <strong>{{ generatedPassword }}</strong>
      </div>

      <div>
        <label class="text-gray-300 text-sm">Nombre</label>
        <input
          v-model="nombre"
          class="w-full mt-1 p-2 rounded bg-[#2a3942] text-white outline-none"
        />
      </div>

      <div>
        <label class="text-gray-300 text-sm">Apellido paterno</label>
        <input
          v-model="apellido_paterno"
          class="w-full mt-1 p-2 rounded bg-[#2a3942] text-white outline-none"
        />
      </div>

      <div>
        <label class="text-gray-300 text-sm">Apellido materno</label>
        <input
          v-model="apellido_materno"
          class="w-full mt-1 p-2 rounded bg-[#2a3942] text-white outline-none"
        />
      </div>

      <div>
        <label class="text-gray-300 text-sm">Correo</label>
        <input
          v-model="email"
          type="email"
          class="w-full mt-1 p-2 rounded bg-[#2a3942] text-white outline-none"
        />
      </div>

      <button
        @click="register"
        class="w-full bg-[#00a884] hover:bg-[#019874] text-white py-2 rounded"
      >
        Registrarse
      </button>

      <p class="text-gray-400 text-center text-sm">
        ¿Ya tienes cuenta?

        <router-link
          to="/"
          class="text-[#00a884] hover:underline"
        >
          Iniciar sesión
        </router-link>
      </p>

    </div>

  </div>
</template>

<script setup>
import { ref } from "vue"
import { registerUser } from "../services/authService"

const nombre = ref("")
const apellido_paterno = ref("")
const apellido_materno = ref("")
const email = ref("")

const generatedPassword = ref("")
const errorMessage = ref("")

async function register(){

  errorMessage.value = ""
  generatedPassword.value = ""

  if(!nombre.value || !apellido_paterno.value || !apellido_materno.value || !email.value){
    errorMessage.value = "Todos los campos son obligatorios"
    return
  }

  try{

    const response = await registerUser({
      nombre: nombre.value,
      apellido_paterno: apellido_paterno.value,
      apellido_materno: apellido_materno.value,
      email: email.value
    })

    generatedPassword.value = response.generated_password

  }
  catch(e){

    errorMessage.value = "El correo ya está registrado"

  }

}
</script>