# Railway Deployment Guide

This guide explains how to configure and deploy the BantayKalusugan PH application to Railway.

## Environment Variables

Railway will automatically provide a `DATABASE_URL` environment variable when you add a MySQL plugin. However, you need to configure the following variables in your Railway project settings:

### Required Variables

```
APP_NAME=BantayKalusugan PH
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-railway-url.up.railway.app
APP_KEY=base64:/WEqNJripr6S7nfFL6/MydFITDL7hi/S6AW99+DXj9Q=

# Session & Cache
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

# Mail
MAIL_MAILER=log

# Filesystem
FILESYSTEM_DISK=local

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=debug
```

### Database Configuration

Railway automatically provides `DATABASE_URL` when you add the MySQL plugin. The application will automatically parse it.

- **No need to set** `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` individually
- **Do not set** `MYSQLHOST`, `MYSQLPORT`, `MYSQLDATABASE`, `MYSQLUSER`, `MYSQLPASSWORD`
- Railway's `DATABASE_URL` is automatically used by the app

## Deployment Steps

### 1. Connect Repository to Railway

1. Go to [Railway.app](https://railway.app)
2. Create a new project
3. Click "Deploy from GitHub repo"
4. Select `jjurencastro/health-monitoring`
5. Authorize and connect

### 2. Add MySQL Plugin

1. In Railway dashboard, click "+ New"
2. Select "MySQL"
3. Click "Create"
4. Railway will automatically set the `DATABASE_URL` variable

### 3. Configure Environment Variables

In Railway project settings, go to "Variables" and add:

```
APP_NAME=BantayKalusugan PH
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:/WEqNJripr6S7nfFL6/MydFITDL7hi/S6AW99+DXj9Q=
APP_URL=<your-railway-domain>
```

Get your Railway domain from the "Domains" tab on your service.

### 4. Run Database Migrations

After first deployment, you need to run migrations:

```bash
php artisan migrate --force
```

To run this on Railway:

1. Go to your service in Railway
2. Click "Deployments"
3. Select the latest deployment
4. Click the terminal icon to access shell
5. Run: `php artisan migrate --force`

Alternatively, you can set up a deployment hook in `Procfile` or use a custom `railway.json`:

```json
{
  "build": {
    "builder": "dockerfile"
  },
  "deploy": {
    "startCommand": "php artisan migrate --force && php -S 0.0.0.0:${PORT:-8000} -t public"
  }
}
```

### 5. Seed Initial Data (Optional)

If you want to seed admin access codes or other data:

```bash
php artisan db:seed --class=AdminAccessCodeSeeder --force
```

## Troubleshooting

### Database Connection Error: "Name or service not known"

This happens when environment variables aren't properly set. Verify:

1. Railway MySQL plugin is added and active
2. `DATABASE_URL` is showing in Railway variables
3. Check logs: Click service → "View Logs" → "Deploy"

### Migrations Won't Run

1. Check if database is accessible: SSH into Railway and run `php artisan migrate --force`
2. If permission denied, add `--force` flag
3. Verify all migrations are in `database/migrations/`

### APP_KEY Error

The `APP_KEY` must be set. If not provided:

```bash
php artisan key:generate
```

Copy the output and set it in Railway variables.

## Local Development

For local development, use `.env` file (already created in project root):

```env
APP_ENV=local
APP_DEBUG=true
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=health_monitoring
DB_USERNAME=root
DB_PASSWORD=
```

## Useful Commands

```bash
# View recent logs
php artisan log:tail

# Check database connection
php artisan tinker
>>> DB::connection()->getPdo()

# List migrations
php artisan migrate:status

# Rollback migrations
php artisan migrate:rollback --force
```
