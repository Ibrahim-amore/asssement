import React, {useEffect, useState} from 'react'
import api from '../api'

export default function Preferences(){
  const [sources,setSources] = useState<string[]>([])
  const [selected,setSelected] = useState<string[]>([])

  useEffect(()=>{
    api.get('/sources').then(r=>setSources(r.data || []))
    api.get('/preferences').then(r=>{
      const prefs = r.data || {}
      setSelected(prefs.sources || [])
    }).catch(()=>{})
  },[])

  const toggle = (s:string) => setSelected(sel => sel.includes(s) ? sel.filter(x=>x!==s) : [...sel,s])
  const save = async () => {
    try{
      await api.post('/preferences', { sources: selected, categories: [], authors: [] })
      alert('Preferences saved')
    }catch(e:any){
      alert('Please login to save preferences')
    }
  }

  return (
    <div className="max-w-2xl mx-auto card">
      <h2 className="text-xl font-semibold mb-4">Customize your feed</h2>
      <div className="flex flex-wrap gap-3">
        {sources.map(s=> (
          <button key={s} onClick={()=>toggle(s)} className={`px-3 py-1 border rounded ${selected.includes(s) ? 'bg-blue-50' : 'bg-white'}`}>
            {s}
          </button>
        ))}
      </div>
      <div className="mt-4">
        <button onClick={save} className="btn">Save preferences</button>
      </div>
    </div>
  )
}
