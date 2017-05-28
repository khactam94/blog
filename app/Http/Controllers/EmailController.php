<?php
 
namespace App\Http\Controllers;
 
use Mail;
use App\Models\User;
use App\Mail\OrderShipped;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Mail\UserEmail;
 
class EmailController extends AppBaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
 
    public function sendEmailReminder(Request $request)
    {
        $id = 1; // điền 1 mã id bất kỳ của user trong bảng users 
        $user = User::findOrFail($id);
        $user->email = "nguyentom071194@gmail.com";
        Mail::to($user)->send(new UserEmail());
    }
}