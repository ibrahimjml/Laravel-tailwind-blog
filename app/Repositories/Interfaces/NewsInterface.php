<?php

namespace App\Repositories\Interfaces;

use App\Models\Hashtag;

interface NewsInterface
{
    public function getAllNewsWithSources();

    public function getLatestSources();
}