# Quick Setup Steps with Docker

1. **Clone the Repository**  
   ```
   git clone https://github.com/nickgkizis/CF-Blog-Docker.git

2. **Build and Start the Containers**
    ```
    docker-compose up -d --build
    
3. **Install Composer Dependencies**
    ```
    docker-compose exec app composer install

4. **Generate the Laravel App Key**
   ```
   docker-compose exec app php artisan key:generate

5. **Run Database Migrations**
   ```
    docker-compose exec app php artisan migrate
6. **Run Seeders**
   ```
   docker-compose exec app php artisan db:seed

7. **Restart the Project**
   ```
   docker-compose down
   docker-compose up -d

8. **The app should be running at localhost:8000**
    
   
