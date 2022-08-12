### To run server please use below commands

Inside "src" run below command

`composer install`

<br>
Copy .env.example to make .env with below database configure

- DB_CONNECTION=mysql
- DB_HOST=mysql
- DB_PORT=3306
- DB_DATABASE=laravel
- DB_USERNAME=homestead
- DB_PASSWORD=secret

### To run docker server
`docker-compose up -d --build`


### To run generate key

`docker-compose run --rm artisan key:generate`


### To run migrate

`docker-compose run --rm artisan migrate `

<hr>

#### For running command inside app you have 2 ways

1 : `docker exec -it lumiform-php bash`
<br>
after above command can run for example  you can run the following command
<br>
    `php artisan optimize`

2 : `docker-compose run --rm artisan optimize`
