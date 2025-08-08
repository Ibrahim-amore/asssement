import React, {useState} from 'react'
import api from '../api'
import {useNavigate} from 'react-router-dom'

export default function Register(){
  const [name,setName]=useState('')
  const [email,setEmail]=useState('')
  const [password,setPassword]=useState('')
  const nav = useNavigate()

  const submit = async (e:any) => {
    e.preventDefault()
    try{
      const res = await api.post('/register',{ name, email, password })
      localStorage.setItem('token', res.data.token)
      nav('/')
    }catch(err:any){
      alert(err?.response?.data?.message || 'Registration failed')
    }
  }

  return (
    <div className="max-w-md mx-auto card">
      <h2 className="text-xl font-semibold mb-4">Create account</h2>
      <form onSubmit={submit} className="space-y-3">
        <input value={name} onChange={e=>setName(e.target.value)} placeholder="Full name" className="w-full p-3 border rounded" />
        <input value={email} onChange={e=>setEmail(e.target.value)} placeholder="Email" className="w-full p-3 border rounded" />
        <input value={password} onChange={e=>setPassword(e.target.value)} placeholder="Password" type="password" className="w-full p-3 border rounded" />
        <button className="btn w-full">Create account</button>
      </form>
    </div>
  )
}
