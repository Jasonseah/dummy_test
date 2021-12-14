[![Code Coverage](https://codecov.io/gh/Jasonseah/dummy_test/branch/main/graph/badge.svg)](https://codecov.io/gh/Jasonseah/dummy_test)

##Welcome to a dummy test (or a v1) of a Laravel w/ CI/CD deployment to GKE

From the root folder of this project run

```
> docker-compose up -d

-d basically is let docker run in the background without the console report  
```

### Setup DB
Then get into the db docker by using this
```
> docker exec -it psql bash
   
> psql -U postgres
> create database <db_name>;
> exit; <- exit the psql

> exit <- exit the docker
```

### Getting into the App docker
Then get into the laravel app docker by using this
```
docker exec -it laravel bash   
```

With the command above you should be able to get in to laravel app server
with that you can run migration and other specific Laravel env setting
```
> cp .env.example .env

> composer install
> php artisan migrate
> php artisan key:generate

to exit 
> exit
```
