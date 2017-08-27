<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class HomeController extends AppBaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('q')){
            $posts = Post::where('status', 2)->where('title', 'like', '%'.$request->q.'%')->orderBy('id','DESC')->paginate(5);
        }
        else {
            $posts = Post::where('status', 2)->orderBy('id','DESC')->paginate(5);
        }
        
        return view('home', compact('posts'));
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
