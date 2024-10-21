<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Projeto


### Passo a passo
Clone Repositório
```sh
git clone https://github.com/edivaner/ecommerce_api.git
```
```sh
cd ecommerce_api
```

Crie o Arquivo .env
```sh
cp .env.example .env
```

Atualize as variáveis de ambiente do arquivo .env
```dosini
APP_NAME=ecommerceBackend
APP_URL=http://localhost:8080

DB_CONNECTION
DB_HOST
DB_PORT
DB_DATABASE=nome_que_desejar_db
DB_USERNAME=nome_usuario
DB_PASSWORD=senha_aqui

CACHE_DRIVER
QUEUE_CONNECTION
SESSION_DRIVER

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_CLIENT=predis
```

Suba os containers do projeto
```sh
docker-compose up --build -d
```
ou
```sh
docker-compose up -d
```

Acesse o container app
```sh
docker-compose exec app bash  / Docker exec -it app bash
```

Instale as dependências do projeto
```sh
composer install
```

Gere a key do projeto Laravel
```sh
php artisan key:generate
```

Gere a migrate do projeto Laravel
```sh
php artisan migrate
```

Gere os seed do projeto Laravel (Opcional): serve para instanciar a popular o banco com dados iniciais.
```sh
php artisan db:seed
```

Para sair de dentro do container
```sh
exit
```

Acesse o projeto
[http://localhost:8080](http://localhost:8080)

