# Laravel Minio Example with Self-Signed SSL and Temporary URL Support

This project demonstrates how to integrate Minio with Laravel and Docker, utilizing HTTPS with a self-signed SSL certificate. It also showcases the use of temporary URLs for secure, time-limited file access.

## Prerequisites

- Docker

## Setup

1. Clone this repository:
   ```
   git clone https://github.com/horatjp/example-laravel-minio.git
   cd example-laravel-minio
   ```

2. Build and start the Docker containers:
   ```
   docker compose up -d
   ```

3. Install Laravel dependencies:
   ```
   docker compose exec app composer install
   ```

4. Copy the `.env.example` file to `.env`:
   ```
   docker compose exec app cp .env.example .env
   ```

5. Generate the application key:
   ```
   docker compose exec app php artisan key:generate
   ```

6. Hosts file:
   Add the following entry to your hosts file:
    ```
    127.0.0.1 laravel.test minio.laravel.test
    ```

7. Access:

    - Laravel: [https://laravel.test](https://laravel.test)
    - Minio: [http://laravel.test:8900](http://laravel.test:8900) (username: minio, password: password)

## Minio Configuration

Minio is configured in the `docker-compose.yml` file:

- The Minio server operates on port 9001, with the management console available on port 8900.
- A bucket named `local` is automatically created on startup with download permissions set.
- Access credentials are configured using environment variables (MINIO_ROOT_USER, MINIO_ROOT_PASSWORD).

## Usage

This example demonstrates how to use Minio as a storage backend for Laravel.

Example of using storage in a Laravel application:

```php
use Illuminate\Support\Facades\Storage;

$disk = Storage::disk('s3');

// Upload a file
$disk->put('test.txt', 'Hello MinIO!!');

// Get the URL of a file
$url = $disk->url('test.txt');
print "Normal URL: " . $url . PHP_EOL;

// Generate a temporary URL
$tempUrl = $disk->temporaryUrl('test.txt', now()->addMinutes(5));
print "Temporary URL: " . $tempUrl . PHP_EOL;
```

## SSL Certificate Note

This sample uses a self-signed SSL certificate for the development environment. For production use, please use an appropriate certificate and set `AWS_SSL_VERIFY` to `true` in the `.env` file.

## Troubleshooting

- If you see SSL certificate warnings, ensure you're in a development environment and add an exception in your browser.
