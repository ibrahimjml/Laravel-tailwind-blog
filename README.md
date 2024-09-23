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
- **User Registration and Login:** Manually implemented Secure user authentication register/login for full customization and best experience.
- **Profile Management:** Users can view their profiles including posts,number of posts,total likes/comments,and edit profile settings name ,email, change password only authorized can access it, including changing their profile image,update and delete current one.
- **Password Management:** Users can change their passwords and reset them if forgotten.
- **Middleware/Policies:** Implement custom middleware for posts, and implement policies to users/posts for authorization and more secure.

#### Blog Posts
- **Create, Read, Update, and Delete (CRUD) Operations:** Users can create new blog post, edit existing one, and delete post they have authored.
- **Save Posts:** Implement Save/Unsave button using fetchApi, user can access to saved page, with the ability to view and remove saved posts.
- **Slugs:** Implemented a unique slug for each post to create descriptive, enhancing search engine visibility and improving
user experience.
- **Like:** Implement Like/Unkike button using fetchApi with Like animation falling hearts for better user experience. 

#### Comments and Replies
- **Comment on Posts:** Users can add comments to blog posts.
- **Reply to Comments:** Users can reply to comments, creating nested comment threads.
- **Delete Comments/Replies:** Users can delete their own comments and replies.

#### Post Sorting and Searching and pagination
- **Sort Posts:** User can sort posts by latest, oldest, and most liked.
- **Search Functionality:** implemented scout driver,users can search for posts using keywords.
- **Pagination:** User can paginate between post pages. 

#### 🚀 All Pages Styled With TailwindCss ,more experience ,more responsive.
🔥🔥 Upcoming very soon Realtime notification ,follow/unfollow,account public/private.

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
8.🗄️ optional for testing seed databse
```
php artisan db:seed
```
9.💻 Run the application
```
php artisan serve
```






## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
