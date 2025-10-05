<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel
# Laravel Blog Application
## Screanshots
 ![Homepage](https://i.postimg.cc/52QLnsxf/127-0-0-1-8000-2.png)
![Blogpage](https://i.postimg.cc/28p16t6V/127-0-0-1-8000-blog-sort-featured-1.png)
![Recentposts tagpage](https://i.postimg.cc/zGb2jVNn/127-0-0-1-8000-hashtag-laravel.png)
![Postpage](https://i.postimg.cc/qRP5NrZc/Screenshot-2025-09-18-233005.png)
![Notification menu](https://i.postimg.cc/kMjCrJdM/Screenshot-2025-09-22-125701.png)
![Reportpost](https://i.postimg.cc/V6v8qzR3/Screenshot-2025-09-18-235631.png)
![Comments model](https://i.postimg.cc/ZKtzkLQ3/Screenshot-2025-10-03-135906.png)
![Profile home](https://i.postimg.cc/KjndgWSX/127-0-0-1-8000-ibrahim123-5.png)
![Profile activity](https://i.postimg.cc/q7g38kpV/Screenshot-2025-09-20-233621.png)
![Profile report](https://i.postimg.cc/L6y6rkmK/Screenshot-2025-09-24-185620.png)
![Qrcode](https://i.postimg.cc/4NZHWvX1/Screenshot-2025-09-20-232729.png)
![Profileinfo setting](https://i.postimg.cc/LXGFkwFJ/Screenshot-2025-06-27-223320.png)
![Profileinfo setting](https://i.postimg.cc/qMwSk0kk/Screenshot-2025-09-21-110503.png)
![{rofileaccount setting](https://i.postimg.cc/RV5zNkT8/Screenshot-2025-06-27-223348.png)
![Create page](https://i.postimg.cc/J4t6yk1w/127-0-0-1-8000-create-5.png)
![Admin home](https://i.postimg.cc/j2ZNBwpR/Screenshot-2025-09-25-210913.png)
![Admin users](https://i.postimg.cc/VsKqqwvj/Screenshot-2025-10-02-170219.png)
![Admin posts](https://i.postimg.cc/7YLNd6d9/Screenshot-2025-10-02-165700.png)
![Admin tags](https://i.postimg.cc/WbFHNTB5/Screenshot-2025-09-27-023607.png)
![Admin categories](https://i.postimg.cc/66Smm8h9/Screenshot-2025-09-25-204413.png)
![Admin slides](https://i.postimg.cc/g0Z0C75Z/Screenshot-2025-10-01-215235.png)
![Admin roles](https://i.postimg.cc/cLbkXYJB/Screenshot-2025-10-02-164920.png)
![Admin permissions](https://i.postimg.cc/L6yx8fjH/Screenshot-2025-10-02-165838.png)
![Admin reports](https://i.postimg.cc/gkFf0wLg/Screenshot-2025-09-25-204732.png)
![Admin notifications](https://i.postimg.cc/gJcCrwX8/Screenshot-2025-06-03-132110.png)



## Features
- **Blog: category, tag, content, web page with infinite scroll pagination.**
- **Home page Slider, multiple sort options blog page.**
- **Full text search using TNTSearch**
- **Responsive admin dashboard  pages with full Ajax CRUD, and multiple analytics and filters.**
- **Dynamic SEO pages.**
- **RESTful API using Sanctum.**
- **Powerfull Permission System: Manage user by permissions, manage permissions , manage rules.**
- **Powerfull profile user management Home/Activities/About pin and unpin posts/ social links update and multiple custom links provided / manage profile views/ share or download Qrcode profile.**
- **Secure Account info profile and Account management.**
- **Identity check via verfication code on changing password and reset pass.**
- **Ajax comments/replies and load more pagination.**
- **TinyMce editor with codeblocks and image upload/update/delete with image zoom effect.**
- **Table Of Content.**
- **Ajax user interactions Likes/Save/Follow/Share and post views.**
- **Multiple reports on post/comment/profile.**
- **Service layer, DTOs for clean code and better validation input**
- **Redis for better performance**


## 🚀 All Pages Styled With TailwindCss ,more experience ,more responsive.
🔥🔥 Upcomig: winning badges by completing competitions |  AI for recommended posts.

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
9.💻 Run the application
```
php artisan serve
```

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
