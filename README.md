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
![Blogpage](https://i.postimg.cc/5NrXpC0Y/127-0-0-1-8000-blog-sort-featured-2.png)
![Recentposts categorypage](https://i.postimg.cc/j5gn5tKf/Screenshot-2025-09-20-223429.png)
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

## User Authentication/Authorization
- **User Registration and Login:** Manually implemented Secure user authentication register/login integrated with reCapthcha v2.
- **Forget Password:** Users can reset password via email notification with reset password button.
- **Confirmation Password:** Confirmation password for accessing edit post page or user settings for more secure.
- **Email Verification:** User must verfied his email berfore making any action.
- **Identity Verification:** User must verify his identity via email verification code after updating his password or reseting his password.
- **Middleware/Policies/Gate:** Implement custom middleware for permissions and policies on user/post/comment for more secure and gate for admin action.
  
## Profile Management
- **Profile Home:** Profile home page for posts and managemnt.
- **Profile Activity:** Recent activities for user in creating post / commented on posts / replied on posts.
- **Profile Aboutme:** User description or talikng about his works.
- **Share Profile:** User can share his profile via whatsapp / facebook / linkedin / twitter / or copy link.
- **Qrcode Profile:** User qrcode profile he can download it to share it.
- **Pin Posts:** User can pin up to 3 posts by sorting order.
- **Profile Info Settings:** User profile info update profile image / cover image / name / phone number / profile bio / add socail links / add custom links.
- **Profile Account Settings:** User profile account for updating username 'user can change username only once '/ email / change password / delete account.

## Admin Management
- **Adminpanel Home:** Card stats with analytics + filter by year management.
- **Adminpanel Users:** User management Ajax blocked users filter / create new user / edit user / delete user / block user /  changing user roles.
- **Adminpanel Posts:** Post management Ajax Sort posts filter / featured images filter /  create new post / edit post / delete post / make feature posts / view posts.
- **Adminpanel Tags:** Tags management Ajax create new Tag / edit tag / delete tag / make feature tag 'hot' / change status 'active','disabled' action.
- **Adminpanel Categories:** Categories management Ajax  create new category / edit category / delete category / make feature category 'hot'.
- **Adminpanel Roles:** Roles management Ajax  create new role + assign permissions to this role / edit role + edit permissions assigned for role / delete role.
- **Adminpanel Permissions:** Permissions management Ajax  create new permission / edit permission / delete permission.
- **Adminpanel Slides:** Dynamic homepage slides   Ajax  create new slide / edit / delete / change order.
- **Adminpanel Post/Comment Reports:** Post Report management filter by status / change status + sending notification to reporter according to the status / delete post  if he broke community roles / delete report.
- **Adminpanel Notifications:** Admin notifications sort by read / unread / notification types by post created / registered new users / commented / replies / likes / follows / profile views / post report.
- **Adminpanel Settings:** Admin settings change  bio  / password change / phone number / username / Aboutme.

## Blog/Post Page
- **Create, Read, Update, and Delete (CRUD) Operations:** Users can create new blog post, edit existing one, and delete post they have authored.
- **TinyMCE editor:** Users can upload images within Tinymce and design fonts for best description and delete them.
- **TinyMCE codesapmples:** users can create code blocks with prism skin to display their codes with copy button for best experience.
- **Hashtags:** Users can create there own hashtags or select one or max 5 hashtags if they are active.
- **Categories:** Users can select one or more categories.
- **Recent posts tags:** Users view posts related to post tag.
- **Recent posts categories:** Users can view posts releated to post category.
- **Sort Posts:** User can sort posts by latest, oldest, most liked, most viewed, featured, following, and trending hashtags.
- **Search Functionality:** implemented scout driver tntsearch indexed posts with fast search ability.
- **Save Posts:** Implement Save/Unsave button using fetch(), user can access to saved page, with the ability to view and remove saved posts.
- **Post Report:** Users can report post once with multiple reasons.
- **Slugs:** Implemented a unique slug for each post to create descriptive, enhancing search engine visibility and improving user experience.
- **Like:** Implement Like/Unkike button using fetch() with Like animation falling hearts for better user experience. 
- **Follow:** User can follow/unfollow using fetch() for faster respond.
- **Profileview:** users can see who viewed their profile and folow/unfollow them if they are not.
- **Postviews:** only posters can see the viewers model and folow/unfollow them if they are not.
- **WhoLiked post :** users can see who liked on their posts and follow/unfollow them.
- **Whoviewed post :** users can see who viewed on their posts and follow/unfollow them.
- **Table Of Contents:** users can navigate between headings inside post description.
- **OPtimization:** Used Eager loading for optimized queries and prevent N+1 queries.

## Comments and Replies Ajax
- **Disable/Enable:** Users can diasble or enable comments from creating or editing post.
- **Comment on Posts:** Users can add comments to blog posts using fetch().
- **Reply to Comments:** Users can replies to comments, creating nested comment system with reply on reply using fetch(), they can see total replies on a comment with ability to hide and show those replies.
- **Delete/Edit Comments/Replies:** Users can delete or edit their own comments and replies using fetch().

## Notifications database and Emails notification
- **Email notification:** Users will get emailed if posts are liked, commented, replied , or viewed their profiles or followed used queues for faster respond.
- **Notification:** users can manage notifications unread or delete notifications.
- **Observer notification:** Auto send and delete notifications for both admin and users based created/deleted structure.

## Custom Roles and Permissions
- **Roles management** 
- **Permissions management** 
- **Give permissions to any user** 

## 🚀 All Pages Styled With TailwindCss ,more experience ,more responsive.
🔥🔥 Upcomig: winning badges by completing competitions | Using AI for recommended posts.

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
