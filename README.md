<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel
# Laravel Blog Application
## 📸 Screenshots

👉 [View Screenshots](SCREENSHOTS.md)

---

## 🚀 Features

### 📝 Content & Blog System
- 📰 Social Blog system with fully cached pages and **infinite scroll pagination**
- 🎯 Multi-blog sorting options
- 🧠 Full-text search powered by **TNTSearch**
- 🧭 Dynamic **Table of Contents (ToC)** generated from post headings
- 🧾 Dynamic SEO management for posts and pages
- 🖊️ **TinyMCE rich text editor** with:
  - Code blocks
  - Image upload / update / delete
  - Image zoom & preview effect

### 🏠 Homepage & User Interface
- 🎞️ Dynamic homepage slider
- 📱 Fully responsive UI built with **Tailwind CSS**
- ⚡ Smooth **AJAX-powered navigation and interactions**

### 💬 Social Interaction
- 💬 **AJAX comments & nested replies** with load-more pagination
- 🔔 **@Mentions in comments** with user notifications
- ❤️ User interactions (AJAX):
  - Like / Unlike
  - Save / Unsave
  - Follow / Unfollow
  - Share posts
  - Track post views
  - Follow request system with accept-follow notifications
- 🚩 Report system for **posts, comments, and profiles**

### 👤 User Profiles & Social Features
- 👥 Advanced profile system including:
  - Profile Home / Activities / About sections
  - Activities : track user profile history (commented, relpied, liked, posted)
  - Pin & unpin posts
  - Social links + custom links
  - Profile view tracking
  - Share or download **profile QR code**
- 🔐 Public & private profile visibility settings
- 🔒 Private profiles accessible only to **accepted followers**

### 🔐 Security & Authentication
- 🎯 Recaptcha v2 
- 🛡️ **Custom Two-Factor Authentication (2FA)**
- 🔑 Secure account and profile management with confirm password
- ✉️ Reset password option via Email verification code
- 🔑 Identity check via Email verification code required on changing password action
- 🔐 RESTful API authentication using **Laravel Sanctum**

### 🧑‍💼 Admin Dashboard & Management
- 📊 Responsive admin dashboard
- ⚡ Full **AJAX CRUD** across admin pages
- ✉️ Custom mail setting for configuring SMTP
- ✉️ Notifications control setting
- 💾 DB backup management
- 📈 Analytics, filters, and reports

### 🛂 Authorization & Permissions
- 🧠 Powerful custom permission system (ACL):
  - Fully cahched Role and permission access control
  - Manage users, roles, permissions, and rules
  - Fine-grained authorization logic

### ⏱️ Scheduler Tasks
- 💾 **Generate daily secure encrypted database backups**
- 🧹 **Weekly backup cleanup** to remove old backups

### 🔔 In-App Notifications
- 🔔 **Emails and in-app notification system** with multiple notification types:
  - Likes, comments, replies
  - @Mentions, profile-views
  - Follow requests & accept notifications
  - Reports and system alerts

### 🧱 Architecture & Performance
- 🧩 Clean architecture using:
  - Service Layer
  - Observers
  - Builders
  - Repositories
  - Decorators
  - DTOs (Data Transfer Objects)
- 🧪 Improved validation and separation of concerns
- 🚀 **Redis caching** for better performance and scalability



## 🚀 All Pages Styled With TailwindCss ,more responsive.
🔥🔥 Upcomig: winning badges by completing competitions |  AI for recommended posts.

---

## INSTALLATION
- **Requirements extensions:**
- **PHP 8.3**
- **Imagick**
- **intl**
- **tokenizer**

1.📦 Install dependencies
```
composer install
```
2.🛠️ Create a copy of the .env file
```
cp .env.example .env
```
3.🔑 Generate the application key
```
php artisan key:generate
```
4.📦 install node_modules
```
npm install
```
5.🚀 Compile assets with Tailwind CSS
```
npm run dev
```
6.🗄️ Set up the database
```
php artisan migrate
```
7.🔗 Create symbolic link for storage
```
rm public/storage
php artisan storage:link
```
8.🗄️ Seed Admin credantials with roles and permessions 
```
php artisan db:seed --AdminSeeder
```
9.🗄️ Seed the SMTP configuration important 
```
php artisan db:seed --SmtpSeeder
```
10.💻 Run the application
```
php artisan serve
```
11.🚀 For better performance configure Redis and enable Cache to true
```
CACHE_ENABLED=true
REDIS_CLIENT=predis
```
## Testing Notifications
- **Configure new smtp in adminpanel->settings->smtp settings**
- **Test it by sending test mail**

## Test the Application
- **Copy .env.testing.example to .env.testing**
- **Run the commands:**
```
php artisan key:generate --env=testing
```
```
php artisan migrate --seed --env=testing
```
```
php artisan serve --env=testing
```
## Admin Login
`Use these credentails to log in as admin`


- Email: admin@mail.ru.
- Pass : adminadmin123.

## Laravel RESTful API for this project <img height="20" src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/Laravel.svg/1200px-Laravel.svg.png" />

All Requests start with http://127.0.0.1:8000/api

`Login`

- `POST /api/login` - login to get token access.

 `posts`
- `GET /api/blog` - Get all posts.No authentication required.
- `GET /api/posts/{post}` - Get single post.No authentication required.
- `POST /api/create` - Create new post , authentication required.
- `PUT /api/post/update/{post}` - Update authorized post, authentication required.
- `DELETE /api/post/{post}` - Delete authorized post, authentication required.

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
