# Nova Business — test Railway

## Architecture
- PHP 8.4 + Apache
- MySQL Railway
- API `/api/catalog.php`
- Health check `/health.php`

## Railway variables
The MySQL service exposes `MYSQLHOST`, `MYSQLPORT`, `MYSQLDATABASE`, `MYSQLUSER`, `MYSQLPASSWORD`.
The web service should receive references to these variables plus a secret `CHATBOT_API_KEY`.

Example values in Railway:
- `MYSQLHOST=${{MySQL.MYSQLHOST}}`
- `MYSQLPORT=${{MySQL.MYSQLPORT}}`
- `MYSQLDATABASE=${{MySQL.MYSQLDATABASE}}`
- `MYSQLUSER=${{MySQL.MYSQLUSER}}`
- `MYSQLPASSWORD=${{MySQL.MYSQLPASSWORD}}`
- `CHATBOT_API_KEY=<secret>`

## Database
Import `database/schema.sql` into the Railway MySQL database using the Railway Data/Query interface or a MySQL client.

## First installation
Open `/admin/setup.php` once to create the first administrator. The setup page refuses creation when an administrator already exists.

## Important for production
Use a strong `CHATBOT_API_KEY`, HTTPS, backups, and a separate production database. Do not use the provisional phone number in production.
