# News Aggregator — Professional Skeleton (Frontend polished + Backend skeleton)

This repo contains a polished frontend (Vite + React + TypeScript + Tailwind) and a complete backend skeleton for Laravel (models, migrations, services, controllers, dockerfile).

## What you get
- Fully styled frontend ready to run (install deps and start with `npm run dev` or build+docker)
- Backend skeleton with all important PHP source files and migrations — to complete, run `composer create-project laravel/laravel .` inside `/backend` and copy these skeleton files into the Laravel project.

## Quick start (Docker)
1. Create a `.env` at the repo root containing API keys:
   NEWSAPI_KEY=your_newsapi
   GUARDIAN_KEY=your_guardian_key
   NYTIMES_KEY=your_nytimes_key

2. Run:
   docker-compose up --build -d

3. In backend container (after Laravel installed):
   docker-compose exec backend php artisan key:generate
   docker-compose exec backend php artisan migrate --force
   docker-compose exec backend php artisan scrape:all

4. Frontend available at http://localhost:3000 (served by nginx after build). For local dev use `cd frontend && npm install && npm run dev` to use Vite dev server (http://localhost:5173).

## Notes
- The backend folder is a skeleton — to run Laravel you must install framework files using Composer (instructions are in backend/README.md).
- The frontend is production-ready; run `npm install` then `npm run build` to produce a dist folder that the Dockerfile serves via nginx.
- If you want, I can complete the backend into a full Laravel app and produce a downloadable zip with everything preinstalled. That requires running Composer to fetch framework files (I can't run Composer here).

If you'd like, I can now provide a walkthrough to finish the backend and run everything locally.
