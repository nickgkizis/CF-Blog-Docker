# Quick Setup Steps with Docker

1. **Clone the Repository**  
   ```
   git clone https://github.com/nickgkizis/CF-Blog-Docker.git
   
2. **Rename .env.example to .env**

3. **Build and Start the Containers**
    ```
    docker-compose up -d --build
    
4. **Install Composer Dependencies**
    ```
    docker-compose exec app composer install

5. **Generate the Laravel App Key**
   ```
   docker-compose exec app php artisan key:generate

6. **Run Database Migrations**
   ```
    docker-compose exec app php artisan migrate
7. **Run Seeders**
   ```
   docker-compose exec app php artisan db:seed

8. **Restart the Project**
   ```
   docker-compose down
   docker-compose up -d

9. **The app should be running at localhost:8000**
    
   
