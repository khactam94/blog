<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class MailController extends AppBaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function mail()
    {
        $user = User::find(1)->toArray();

        Mail::send('khac.tam.94@gmail.com', $user, function($message) use ($user) {
            $message->to('nguyentom071194@gmail.com');
            $message->subject('E-Mail Example');
        });

        dd('Mail Send Successfully');
    }
}
