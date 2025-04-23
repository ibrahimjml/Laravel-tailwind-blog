<?php

namespace App\Observers;

use App\Models\Hashtag;

class HasgtagObserver
{
    
    

    /**
     * Handle the Hashtag "deleted" event.
     */
    public function deleted(Hashtag $hashtag): void
    {
      $hashtag->posts()->detach();
    }


}
