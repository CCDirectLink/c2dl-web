# https://c2dl.info

Content of the c2dl.info website(s)

## Environment

- PHP: 8.1
- Composer
- NodeJS
- MySQL

## Environment Variables

- <https://c2dl.info> page root: `/src/c2dl/public`
- `/src/c2dl/.env` required see [example](/src/c2dl/.env.example)

## Setup

- Navigate to directory /src/c2dl
- Run `npm install`
- Configure `/src/c2dl/.env` (see also `php artisan key:generate`)
- Run `php artisan migrate` for setting up the database
**[OR]** Run `php artisan migrate --seed` for setting up the database and seed it
- Add required *images* to `/src/c2dl/public/images`
- Add required *fonts* to `/src/c2dl/public/fonts`

-------

CCDirectLink <info@c2dl.info>
