# Lumenblog - Blog API using Lumen
Simple blog engine using Lumen API with JWT Token based authentication.

## Setup (using Docker - Recommended)
1. Clone this repo, `git clone https://github.com/budhilaw/lumenblog.git`
2. Composer install, `composer install`
3. Migrate Database, `php artisan migrate:fresh`
4. Start docker compose, `docker-compose up`

#### `.env` File
Don't forget to edit `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` and `JWT_SECRET`

## Features
- [x] User ( `CREATE`, `READ`, `UPDATE`, `DELETE` )
- [x] Post ( `CREATE`, `READ`, `UPDATE`, `DELETE` )
- [ ] Categories ( `CREATE`, `READ`, `UPDATE`, `DELETE` )
- [ ] Pages ( `CREATE`, `READ`, `UPDATE`, `DELETE` )

## License
This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
