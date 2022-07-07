# Установка проекта

## Back-end

1. Сбірка/запуск контейнерів

    ```bash
    $ docker-compose build
    $ docker-compose up -d
    ```

2. У корені проекту і в директорії /symfony і /processing - копіюємо файл .env і даємо нове ім'я .env.local де прописуємо свої параметри (хости, підключення до бази ...)
3. Заходимо в контейнер mysql щоб створити потрібні нам бази даних і зробити дамп

    ```bash
    $ docker-compose exec mysql bash
    ```

4. Налаштовуємо процесинг, йдемо в директорію /processing і виконуємо composer install. Щоб перевірити, чи працює процесинг, переходимо за адресою http://localhost:82/admin/login

5. Перевіряємо адмінку http://localhost:81/a5dm/
6. Перевіряємо основний сайт http://localhost

### Корисні команди

```bash
# bash commands
$ docker-compose exec php-www bash
# Composer (e.g. composer update)
$ docker-compose exec php-www composer update
# SF commands (Tips: there is an alias inside php container)
$ docker-compose exec php-www php /var/www/symfony/bin/console cache:clear
# Same command by using alias
$ docker-compose exec php-www bash
$ sf cache:clear
# Retrieve an IP Address (here for the nginx container)
$ docker inspect --format '{{ .NetworkSettings.Networks.dockersymfony_default.IPAddress }}' $(docker ps -f name=nginx -q)
$ docker inspect $(docker ps -f name=nginx -q) | grep IPAddress
# MySQL commands
$ docker-compose exec mysql mysql -uroot -p"root"
# F***ing cache/logs folder
$ sudo chmod -R 777 var/cache var/logs
# Check CPU consumption
$ docker stats $(docker inspect -f "{{ .Name }}" $(docker ps -q))
# Delete all containers
$ docker rm $(docker ps -aq)
# Delete all images
$ docker rmi $(docker images -q)
```


## Front-end

**cd symfony** - всі дії виконуємо в директорії "symfony"

**npm install** - встановити всі необхідні пакети  
**npm ci** - перевстановити пакети, чисте інсталювання (при необхідності)

**npm run dev** - запуск дев версії  
**npm run build** - збірка проекту для продакшену  
**npm run analyze** - візуальний аналіз продакшн збірки  
**npm run lint** - лінтінг js

**/symfony/public/build** - директорія куди відбудеться білд проекту

## за потреби
**rm -rf ./node_modules** - видаляємо node modules  
**rm -rf ./public/build** - видаляємо білд проекту  
