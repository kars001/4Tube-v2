<img src="https://github.com/tallandcollege/introductie-project-youtube/blob/main/Source/youtube/storage/app/public/fav.png?raw=true" alt="logo" title="4Tube" align="right" height="60" />

# 4Tube

4Tube is a youtube clone that allows to upload, manage, view and interact with video's. Made with laravel and tailwindcss the design works on all devices without any issues.
![image](https://github.com/user-attachments/assets/d85f8ba4-21c4-476d-9d7a-5f28a9c1f02c)

# Table Of Content
- [Installation](#installation)

# Installation
The following is required:
- Composer
- npm
- laravel
- php
- php pdo sqlite

### 1. Install laravel
```bash
composer global require laravel/installer
```

### 2. Install requirements
Install all libraries and packages.
```bash
npm i
```
and
```bash
composer i
```
and
```bash
composer require algolia/algoliasearch-client-php
```

### 3. Migrate database and link storage.
```bash
php artisan migrate:refresh --seed
```
and
```bash
php artisan storage:link
```
Make sure to also generate a key, do this after renaming .env.example to .env
```bash
php artisan key:generate
```

### 4. Configure env
Go to `example.env` and rename the file to `.env` and configure mailtrap and cloudflare r2.

### 5. Run
Run and open the application by going to `127.0.0.1:8000`.
```bash
composer run dev
```
