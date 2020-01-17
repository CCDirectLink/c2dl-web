# https://c2dl.info

Content of the c2dl.info website(s)

## Environment

- PHP: 7.3
- Composer
- NodeJS
- MySQL

## Environment Variables

- <https://c2dl.info> page root: `/src/c2dl/public/www-c2dl/`
- `/src/c2dl/.env` required see [example](/src/c2dl/.env.example)

## Setup

- Navigate to directory /src/c2dl
- Run `npm install`
- Configure `/src/c2dl/.env` (see also `php artisan key:generate`)
- Run `php artisan migrate` for setting up the database
**[OR]** Run `php artisan migrate --seed` for setting up the database and seed it
- Add required *svg data* to `/src/c2dl/resources/views/svgdata/ext`
- Add required *images* to `/src/c2dl/public/www-c2dl/images`
- Add required *fonts* to `/src/c2dl/public/www-c2dl/fonts`

-------

CCDirectLink <info@c2dl.info>
