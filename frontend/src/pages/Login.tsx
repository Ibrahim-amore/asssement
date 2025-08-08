import React, {useState} from 'react'
import api from '../api'
import {useNavigate, Link} from 'react-router-dom'

export default function Login(){
  const [email,setEmail]=useState('')
  const [password,setPassword]=useState('')
  const nav = useNavigate()

  const submit = async (e:any) =>{
    e.preventDefault()
    try{
      const res = await api.post('/login', { email, password })
      localStorage.setItem('token', res.data.token)
      nav('/')
    }catch(err:any){
      alert(err?.response?.data?.message || 'Login failed')
    }
  }

  return (
    <div className="max-w-md mx-auto card">
      <h2 className="text-xl font-semibold mb-4">Login</h2>
      <form onSubmit={submit} className="space-y-3">
        <input value={email} onChange={e=>setEmail(e.target.value)} placeholder="Email" className="w-full p-3 border rounded" />
        <input value={password} onChange={e=>setPassword(e.target.value)} placeholder="Password" type="password" className="w-full p-3 border rounded" />
        <div className="flex items-center justify-between">
          <button className="btn">Login</button>
          <Link to="/register" className="text-sm link">Create account</Link>
        </div>
      </form>
    </div>
  )
}
