<?php

namespace App\Enums;

enum PermissionModule:string
{
    case USER = 'User';
    case POSTS = 'Posts';
    case COMMENTS = 'Comments';
    case CATEGORY = 'Categories';
    case TAG = 'Tags';
    case ROLES = 'Roles';
    case PERMISSIONS = 'Permissions';
    case POSTREPORT = 'Post Reports';
    case COMMENTREPORT = 'Comment Reports';
}
