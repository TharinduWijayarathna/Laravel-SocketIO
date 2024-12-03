
# Laravel Soketi Setup Guide

This guide will walk you through setting up Laravel with Soketi, a fast, scalable WebSockets server compatible with Pusher.

---

## Prerequisites

- **PHP** >= 8.1
- **Composer**
- **Node.js** >= 16
- **Redis** (optional but recommended for efficient broadcasting)
- **Soketi** installed globally (or via Docker)

---

## Step 1: Install Laravel

1. Create a new Laravel project:
   ```bash
   composer create-project laravel/laravel laravel-soketi-example
   cd laravel-soketi-example
   ```

2. Install Laravel Echo and Pusher:
   ```bash
   npm install --save-dev laravel-echo pusher-js
   ```

---

## Step 2: Install Soketi

1. Install Soketi globally:
   ```bash
   npm install -g @soketi/soketi
   ```

2. Alternatively, use Docker to run Soketi:
   ```bash
   docker run -d --name soketi -p 6001:6001 quay.io/soketi/soketi
   ```

---

## Step 3: Configure Laravel

1. Update the `.env` file with the following values:
   ```
   BROADCAST_DRIVER=pusher
   PUSHER_APP_ID=app-id
   PUSHER_APP_KEY=app-key
   PUSHER_APP_SECRET=app-secret
   PUSHER_HOST=127.0.0.1
   PUSHER_PORT=6001
   PUSHER_SCHEME=http
   PUSHER_APP_CLUSTER=mt1
   ```

2. Install Laravel broadcasting configuration:
   ```bash
   php artisan vendor:publish --tag=laravel-echo
   ```

3. Update the `config/broadcasting.php` file:
   ```php
   'pusher' => [
       'driver' => 'pusher',
       'key' => env('PUSHER_APP_KEY'),
       'secret' => env('PUSHER_APP_SECRET'),
       'app_id' => env('PUSHER_APP_ID'),
       'options' => [
           'host' => env('PUSHER_HOST'),
           'port' => env('PUSHER_PORT'),
           'scheme' => env('PUSHER_SCHEME'),
           'cluster' => env('PUSHER_APP_CLUSTER'),
           'useTLS' => false,
       ],
   ],
   ```

---

## Step 4: Run Laravel and Soketi

1. Start the Laravel server:
   ```bash
   php artisan serve
   ```

2. Start Soketi:
   ```bash
   soketi start
   ```

---

## Step 5: Verify

- Access your Laravel app and verify the WebSocket connection is active.
- Check the browser's console for any errors or issues.

---

Enjoy your real-time features with Laravel and Soketi!
