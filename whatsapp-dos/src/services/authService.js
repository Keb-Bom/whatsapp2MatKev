import api from "./api"

export const registerUser = async (userData) => {

  const response = await api.post("/register",{
    nombre: userData.nombre,
    apellido_paterno: userData.apellido_paterno,
    apellido_materno: userData.apellido_materno,
    email: userData.email
  })

  return response.data
}

export const loginUser = async (credentials) => {

  const response = await api.post("/login",{
    email: credentials.email,
    password: credentials.password
  })

  return response.data
}

export const getMe = async ()=>{

 const res = await api.get("/me")

 return res.data

}