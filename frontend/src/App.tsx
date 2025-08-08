import React from 'react'
import { Routes, Route, Link } from 'react-router-dom'
import Articles from './pages/Articles'
import Login from './pages/Login'
import Register from './pages/Register'
import Preferences from './pages/Preferences'

export default function App() {
  return (
    <div>
      <header className="header">
        <div className="container flex items-center justify-between h-16">
          <Link to="/" className="font-semibold text-xl">NewsHub</Link>
          <nav className="flex items-center gap-4">
            <Link to="/preferences" className="text-sm text-gray-700">Preferences</Link>
            <Link to="/login" className="btn">Login</Link>
          </nav>
        </div>
      </header>

      <main className="container py-8">
        <Routes>
          <Route path='/' element={<Articles/>} />
          <Route path='/login' element={<Login/>} />
          <Route path='/register' element={<Register/>} />
          <Route path='/preferences' element={<Preferences/>} />
        </Routes>
      </main>
    </div>
  )
}
