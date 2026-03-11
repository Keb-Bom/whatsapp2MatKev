import axios from "axios"

const api = axios.create({
  baseURL: "https://matroxmata.com/chat/backend",
  headers:{
    "Content-Type":"application/json"
  },
  withCredentials:true
})

export default api