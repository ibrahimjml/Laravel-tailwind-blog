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
 ![Homepage](https://i.postimg.cc/wTzCLcrg/127-0-0-1-8000-7.png)
![Blogpage](https://i.postimg.cc/Y0dRMJDD/Screenshot-2025-09-20-223552.png)
![Recentposts categorypage](https://i.postimg.cc/j5gn5tKf/Screenshot-2025-09-20-223429.png)
![Postpage](https://i.postimg.cc/qRP5NrZc/Screenshot-2025-09-18-233005.png)
![Reportpost](https://i.postimg.cc/V6v8qzR3/Screenshot-2025-09-18-235631.png)
![Commentsmodel](https://i.postimg.cc/qBxC0ZBV/Screenshot-2025-04-22-202005.png)
![Profile home](https://i.postimg.cc/xdFL7X61/Screenshot-2025-09-20-233534.png)
![Profile activity](https://i.postimg.cc/q7g38kpV/Screenshot-2025-09-20-233621.png)
![Qrcode](https://i.postimg.cc/4NZHWvX1/Screenshot-2025-09-20-232729.png)
![Profileinfo setting](https://i.postimg.cc/LXGFkwFJ/Screenshot-2025-06-27-223320.png)
![{rofileaccount setting](https://i.postimg.cc/RV5zNkT8/Screenshot-2025-06-27-223348.png)
![Create page](https://i.postimg.cc/J4t6yk1w/127-0-0-1-8000-create-5.png)
![Admin home](https://i.postimg.cc/qvNG8Dgy/Screenshot-2025-09-20-225312.png)
![Admin users](https://i.postimg.cc/85pSxY91/Screenshot-2025-06-04-112530.png)
![Admin posts](https://i.postimg.cc/vZSrdZ0X/Screenshot-2025-06-06-122828.png)
![Admin tags](https://i.postimg.cc/bNsnMD8j/Screenshot-2025-09-20-225451.png)
![Admin categories](https://i.postimg.cc/zB8WPxDd/Screenshot-2025-09-20-225347.png)
![Admin roles](https://i.postimg.cc/7YprXYdr/Screenshot-2025-06-03-132057.png)
![Admin reports](https://i.postimg.cc/65tKmNwK/Screenshot-2025-06-15-175542.png)
![Admin notifications](https://i.postimg.cc/gJcCrwX8/Screenshot-2025-06-03-132110.png)



### Features

#### User Authentication/Authorization and Admin/profile Management
- **User Registration and Login:** Manually implemented Secure user authentication register/login integrated with reCapthcha v2.
- **Admin Panel:** Admin page management system with notifications sections/manage hashtags/posts/users/reports/roles/permissions, create featured posts to display on homescreen,with filtering and pagination.
- **Profile Management:** profile management for users to see their posts,number of posts,total likes/comments,and edit profile settings users must confirm their passwords before accessing this page,they can edit bio/name/email/change current password, and delete their account by confirming current password,including changing their profile image,update and delete current one,edit cover photo.
- **Profile/RecentActivities/About:** users can see their recent activities in their profile and see their about page.
- **Password Management:** Users can change their passwords and reset them if forgotten.
- **Email Verification:** User must verfied his email berfore making any action.
- **Middleware/Policies/Gate:** Implement custom middleware and policies on user/post for more secure.

#### Blog Posts
- **Create, Read, Update, and Delete (CRUD) Operations:** Users can create new blog post, edit existing one, and delete post they have authored.
- **TinyMCE editor:** Users can upload images within Tinymce and design fonts for best description and delete them.
- **TinyMCE codesapmples:** users can create code blocks with prism skin to display their codes with copy button for best experience.
- **Hashtags:** Users can create there own hashtags or select used hashtags.
- **Save Posts:** Implement Save/Unsave button using fetch(), user can access to saved page, with the ability to view and remove saved posts.
- **Post Report:** Users can report post once with multiple reasons.
- **Slugs:** Implemented a unique slug for each post to create descriptive, enhancing search engine visibility and improving user experience.
- **Like:** Implement Like/Unkike button using fetch() with Like animation falling hearts for better user experience. 
- **Follow:** User can follow/unfollow using fetch() for faster respond.
- **Profileview:** users can see who viewed their profile and folow/unfollow them if they are not.
- **Postviews:** only posters can see the viewers model and folow/unfollow them if they are not.
- **WhoLiked:** users can see who liked on their posts and follow/unfollow them.
- **Table of contents:** users can navigate between headings inside post description.
- **OPtimization:** Used Eager loading for optimized queries and prevent N+1 queries.

#### Comments and Replies 
- **Disable/Enable:** Users can diasble or enable comments from creating or editing post.
- **Comment on Posts:** Users can add comments to blog posts using fetch().
- **Reply to Comments:** Users can replies to comments, creating nested comment system with reply on reply using fetch(), they can see total replies on a comment with ability to hide and show those replies.
- **Delete/Edit Comments/Replies:** Users can delete or edit their own comments and replies using fetch().


#### Post Sorting and Searching and pagination
- **Sort Posts:** User can sort posts by latest, oldest, most liked, most viewed, featured, following, and trending hashtags.
- **Search Functionality:** implemented scout driver tntsearch indexed posts with fast search ability.
- **Pagination:** User can paginate between post pages. 

### Notifications database and Emails notification
- **Email notification:** Users will get emailed if posts are liked, commented, replied , or viewed their profiles or followed used queues for faster respond.
- **Notification:** users can manage notifications unread or delete notifications.
- **Observer notification:** Auto send and delete notifications for both admin and users based created/deleted structure.

### Custom Roles and Permissions
- **Custom Roles** 
- **Custom Permissions** 
- **Give permissions to any user** 

#### 🚀 All Pages Styled With TailwindCss ,more experience ,more responsive.
🔥🔥 Upcomig: likes on comments,private|public accounts.

## INSTALLATION
-- Requirements extensions:
- **PHP 8.3, Imagick, intl**

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
