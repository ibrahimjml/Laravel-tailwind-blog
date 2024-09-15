<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel
# Laravel Blog Application

## Project Description

This Laravel Blog Application is a full-featured web application that provides users with a platform to create, manage, and interact with blog posts. It offers a variety of functionalities designed to enhance user experience and engagement. Below is a detailed overview of the features implemented in this project:

### Features

#### User Authentication/Authorization and Profile Management
- **User Registration and Login:** Secure user authentication with email verification.
- **Profile Management:** Users can view and update their profiles name ,email, including changing their profile images.
- **Password Management:** Users can change their passwords and reset them if forgotten.
- **Middleware/Policies:** Give privileges to user who can comment/delete comment , delete post , like/unlike ,edit profile.
- 
#### Blog Posts
- **Create, Read, Update, and Delete (CRUD) Operations:** Users can create new blog posts, edit existing ones, and delete posts they have authored.
- **Save Posts:** Users can save posts to saved using fetchApi, with the ability to view and remove saved posts.
- **Slugs:** Implemented slugs for each post to create descriptive, enhancing search engine visibility and improving
user experience.
- **Like:** Using fetchApi user can Like/Unkike with animation falling hearts to improve user experience. 

#### Comments and Replies
- **Comment on Posts:** Users can add comments to blog posts.
- **Reply to Comments:** Users can reply to comments, creating nested comment threads.
- **Delete Comments/Replies:** Users can delete their own comments and replies.

#### Post Sorting and Searching and pagination
- **Sort Posts:** Users can sort posts by latest, oldest, and most liked.
- **Search Functionality:** Users can search for posts using keywords.
- **Pagination:** implemented scout driver to let user paginate between pages. 

#### 🚀 All Pages Styled With TailwindCss ,more experience ,more responsive.
🔥🔥 Upcoming very soon Realtime notification,follow/unfollow,account public/private.

## INSTALLATION
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
8.💻 Run the application
```
php artisan serve
```






## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
