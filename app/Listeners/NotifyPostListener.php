<?php

namespace App\Listeners;

use App\Events\NotifyPost;
use App\Mail\NotifyPostMailable;
use App\Models\Post;
use App\Models\Subcriber;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class NotifyPostListener implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NotifyPost  $event
     * @return void
     */
    public function handle(Post $post)
    {
        $subcribers = Subcriber::where('token', '')->get();
        foreach ($subcribers as $subcriber){
            Mail::to($subcriber)->queue(new NotifyPostMailable($post));
        }
    }

    public function failed(Post $post, $exception)
    {
        //
    }
}
