
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

1. Clone the Laravel project:
   ```bash
   git clone https://github.com/TharinduWijayarathna/Laravel-SocketIO.git
   cd Laravel-SocketIO
   ```

2. Install Node Modules:
   ```bash
   npm i
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
