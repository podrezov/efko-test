# EFKO-TEST

## Build Setup

```bash
# clone project
$ git clone git@github.com:podrezov/efko-test.git

# change dir project
$ cd efko-test

# copy .env
$ cp .env.example .env

# run docker
$ cd docker-efko
$ docker-compose up --build -d
$ docker-compose exec php-fpm bash
  # install dependencies
  $ composer i
  # generate key
  $ php artisan key:generate
  # run migrate
  $ php artisan migrate
  # run db seed
  $ php artisan db:seed


# install dependencies
$ npm install

# build for production
$ npm run prod
```

For detailed explanation on how things work, check out [Laravel docs](https://laravel.com/docs/8.x).

