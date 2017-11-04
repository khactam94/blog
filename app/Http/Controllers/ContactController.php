<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SubcribeRequest;
use App\Mail\SubcirbeMailable;
use Illuminate\Support\Facades\Mail;
use App\Models\Subcriber;
use Uuid;
use Flash;

class ContactController extends Controller
{
    /**
     * Email the subcribe request
     *
     * @param SubcribeRequest $request
     * @return Redirect
     */
    public function subcribe(Request $request, $token)
    {
        $subcriber = Subcriber::where('token', $token)->first();
        if(empty($token) || $subcriber == null){
            abort(403);
        }
        $subcriber->update(['token' => null]);

        Flash::success('You subcribed successfully!');
        return redirect()->route('home');
    }
    /**
     * Email the subcribe request
     *
     * @param SubcribeRequest $request
     * @return Redirect
     */
    public function sendSubcribeLink(SubcribeRequest $request)
    {
        $email = $request->input('email');
        $subcriber = Subcriber::where('email', $email)->first();
        $token = Uuid::generate()->string;
        if($subcriber){
            if(empty($subcriber->token)){
                Flash::success('You subcribed successfully!');
                return back();
            }
            $subcriber->update(['token' => $token]);
        }
        else{
            $subcriber = Subcriber::create(['email' => $email, 'token' => $token]);
        }
        Mail::to($email)->queue(new SubcirbeMailable($subcriber->token));
        Flash::success('Thank you for your subcirbe. Please check your email to active your subcribe!');
        return back();
    }
}
