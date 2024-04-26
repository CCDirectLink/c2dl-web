# https://c2dl.info

Content of the c2dl.info website(s)

## Environment

- PHP: 8.2 or 8.3
- Composer
- NodeJS
- MySQL

## Environment Variables

- <https://c2dl.info> page root: `/src/c2dl/public`
- `/src/c2dl/.env` required see [example](/src/c2dl/.env.example)

## Local setup

- Navigate to directory /src/c2dl
- Run `composer install`
- Run `npm install`
- Run `npm run dev` (dev css and assets) or `npm run build`
- Configure `/src/c2dl/.env` (see also `php artisan key:generate`)
- Run `php artisan migrate` for setting up the database
- **[OR]** Run `php artisan migrate --seed` for setting up the database and seed it

## Docker setup

Run `docker/dev_setup.sh` or:

- Copy `docker/conf/env/dev_env` to `src/c2dl/.env`
- Run `docker compose up -d --wait`
- Wait for c2dl-node (exits when finished), c2dl-composer (exits when finished) and c2dl-mysql (keeps running) to finish/start
- Run `docker exec -it c2dl-php sh -c "php artisan key:generate"`
- Run `docker exec -it c2dl-php sh -c "php artisan migrate --seed"` (with seed) or `docker exec -it c2dl-php sh -c "php artisan migrate"` (without seed)

-------

CCDirectLink <info@c2dl.info>
