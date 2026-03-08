import api from "./api"

export const getMessages = async (userId) => {

 const res = await api.get(`/messages?user=${userId}`)
 return res.data

}

export const sendMessage = async (receiverId,message)=>{

 const res = await api.post("/send-message",{
  receiver_id:receiverId,
  message:message
 })

 return res.data

}

export const markMessagesAsRead = async (userId)=>{

 await api.post(`/read-messages?user=${userId}`)

}