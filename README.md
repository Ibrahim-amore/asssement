# asssement
docker-compose up --build -d docker-compose exec backend php artisan key:generate docker-compose exec backend php artisan migrate --force docker-compose exec backend php artisan scrape:all # frontend dev cd frontend &amp;&amp; npm install &amp;&amp; npm run dev
