import React, { useEffect, useState } from 'react'
import api from '../api'

type Article = {
  id:number; title:string; content?:string; url:string; author?:string; source_name?:string;
  image_url?:string; published_at?:string;
}

export default function Articles(){
  const [articles,setArticles] = useState<Article[]>([])
  const [q,setQ] = useState('')
  const [source,setSource] = useState('')
  const [sources,setSources] = useState<string[]>([])
  const [loading,setLoading] = useState(false)

  const fetchArticles = async () => {
    setLoading(true)
    try{
      const res = await api.get('/articles', { params: { q, source, per_page: 12 } })
      const data = res.data.data ?? res.data
      setArticles(data || [])
    }catch(e){ console.error(e) }
    setLoading(false)
  }

  useEffect(()=>{
    api.get('/sources').then(r=>setSources(r.data || []))
    fetchArticles()
  // eslint-disable-next-line
  },[])

  const onSearch = async (e:React.FormEvent) => { e.preventDefault(); fetchArticles(); }

  return (
    <div>
      <form onSubmit={onSearch} className="mb-6 grid grid-cols-1 md:grid-cols-3 gap-3">
        <input value={q} onChange={e=>setQ(e.target.value)} placeholder="Search headlines, content..." className="p-3 border rounded-md col-span-2" />
        <div className="flex gap-2">
          <select value={source} onChange={e=>setSource(e.target.value)} className="p-3 border rounded-md w-full">
            <option value=''>All sources</option>
            {sources.map(s=> <option key={s} value={s}>{s}</option>)}
          </select>
          <button className="btn">Search</button>
        </div>
      </form>

      {loading ? <div>Loading...</div> : (
        <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
          {articles.map(a => (
            <article key={a.id} className="card">
              <div className="flex items-start gap-3">
                <div className="flex-1">
                  <h3 className="font-semibold text-lg">{a.title}</h3>
                  <p className="text-xs text-gray-500 my-1">{a.source_name} • {a.published_at ? new Date(a.published_at).toLocaleString() : ''}</p>
                  <p className="text-sm text-gray-700">{a.content ? a.content.slice(0,140) + (a.content.length>140 ? '...' : '') : ''}</p>
                </div>
              </div>
              <div className="mt-3">
                <a className="link" href={a.url} target="_blank" rel="noreferrer">Read original</a>
              </div>
            </article>
          ))}
        </div>
      )}
    </div>
  )
}
