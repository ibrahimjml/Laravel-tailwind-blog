<?php

namespace App\Repositories\Interfaces;

use App\Models\Hashtag;

interface TagInterface
{
    public function getPostsByTag(Hashtag $hashtag);
}
