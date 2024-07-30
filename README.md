## Minimum Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher

## Setup

Make sure to install the dependencies:

```bash
composer install
```

Create a database and import the mysql database form `database.sql` file

```bash
# On Linux(Ubuntu) OR WSL
mysql -h localhost -u username -p database_name < database.sql
```
*The products table have a column called `attributes` of type `json` that is supproted in MySql: 5.7 or higher*

Configure a `.env` file

```env
APP_NAME=Scandiweb-Task
APP_URL=http://localhost:8000
FRONTEND_URL=http://localhost:3000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=scandiweb_task
DB_USERNAME=root
DB_PASSWORD=password
```

## Development Server

Start the development server on `http://localhost:8000`:

```bash
cd public
php7.4 -S localhost:8000
```
