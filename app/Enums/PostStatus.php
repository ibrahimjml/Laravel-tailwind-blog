<?php

namespace App\Enums;

enum PostStatus:string
{
    case PUBLISHED = 'published';
    case BANNED = 'banned';
    case UNDER_REVIEW = 'under review';
    case TRASHED = 'trashed';
}
