<?php

namespace App\Listeners;

use App\Events\PostEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Session\Store;
use App\Models\Post;

class ViewPostHandler
{
    private $session;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Handle the event.
     *
     * @param  Post  $event
     * @return void
     */
    public function handle(Post $post)
    {
        if (!$this->isPostViewed($post))
        {
            $post->increment('view');
            $this->storePost($post);
        }
    }

    private function isPostViewed(Post $post)
    {
        $viewed = $this->session->get('viewed_posts', []);

        return array_key_exists($post->id, $viewed);
    }

    private function storePost(Post $post)
    {
        $key = 'viewed_posts.' . $post->id;

        $this->session->put($key, time());
    }
}
