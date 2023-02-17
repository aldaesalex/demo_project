# Proyecto dummy

Getting Started

## 1. Install

Run the following command:

- git clone https://github.com/aldaesalex/demo_project.git

- git fetch origin master 

- git checkout master

- cd demo_project

- composer install

- cp .env.example .env

- php artisan key:generate

## 2. Configure 

 ### file .env (development)

- DB_CONNECTION=mysql
- DB_HOST=127.0.0.1
- DB_PORT=3306
- DB_DATABASE=namedatabase
- DB_USERNAME=myuser
- DB_PASSWORD=mypassword

### file config/database.php (production)

 - 'mysql' => [
            'driver' => 'mysql',
            'url' => 'DATABASE_URL',
            'host' => 'my_ip',
            'port' => 'server_port'),
            'database' => 'name_database',
            'username' => 'USERNAME',
            'password' => 'DB_PASSWORD',
            
### Import data

- php artisan migrate --path="database/migrations/2023_02_15_141519_create_zip_codes_table.php"
- php artisan db:seed --class=ZipCodesSeeder (takes several minutes, imports 151649 records)

### Run

- php artisan serve --port=8083

### Test

- php artisan test
- ![image](https://user-images.githubusercontent.com/125467447/219588926-5796a51e-336e-4904-81be-5c77aacd2af6.png)

- http://localhost:8083/api/zip-codes/01210   (HttpStatusCode 200)
- ![image](https://user-images.githubusercontent.com/125467447/219589537-1a77ccf6-9579-42bf-957c-270b4b61ebf9.png)
- http://localhost:8083/api/zip-codes/012104 (HttpStatusCode 422)
- ![image](https://user-images.githubusercontent.com/125467447/219589981-0ead9f0f-5c59-4559-9aae-f5f733cf0ebc.png)
- http://localhost:8083/api/zip-codes/dummy (HttpStatusCode 422)
- ![image](https://user-images.githubusercontent.com/125467447/219590150-bbc6e360-84fc-4f27-8517-9f93dcc7f11a.png)
- http://localhost:8083/api/zip-codes/12 (HttpStatusCode 404)
- ![image](https://user-images.githubusercontent.com/125467447/219590367-5fdccf15-aee8-4553-be99-76d38f09cb6f.png)
- 



