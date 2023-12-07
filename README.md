# SPA-Test

## Requirements
- Docker
- Npm

## Installation

1. Clone the repository:
   ```
   git clone https://github.com/truenormis/spa-test.git
   ```

2. Copy `.env.example` to `.env` and set your Telegram Token and User ID.

3. Set privileges:
   ```
   chmod -R 777 ./
   ```

4. If you encounter any errors, create the necessary folder:
   ```
   mkdir storage/app/public/images
   ```

5. Build and run Docker:
   ```
   docker-compose build
   docker-compose up -d
   ```

6. Access the Docker bash:
   ```
   docker exec -it spa-app bash
   ```

7. Install requirements within the container:
   ```
   composer install
   ```

8. Generate a key:
   ```
   php artisan key:generate
   ```

9. Run Vite:
   ```
   npm install
   npm run dev
   ```
   or
   ```
   npm install
   npm run build
   ```

10. Set up the database:
    ```
    php artisan migrate
    ```

Now your SPA-Test environment should be set up and ready to use.
