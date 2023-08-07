<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use constGuards;
use constDefaults;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;


class AdminController extends Controller
{
    public function loginHandler(Request $request){
        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';


        if($fieldType == 'email'){
            $request->validate([
                'login_id'=>'required|email|exists:admins,email',
                'password'=>'required|min:5|max:45'
            ],[
                'login_id.required'=>'Email or Username is required',
                'login_id.email'=>'Invalid email address',
                'login_id.exists'=>'Email does not exists in the system',
                'password.required'=>'Password is required'
            ]);
        }else{
            $request->validate([
                'login_id'=>'required|exists:admins,username',
                'password'=>'required|min:5|max:45'
            ],[
                'login_id.required'=>'Email or Username is required',
                'login_id.exists'=>'Username does not exists in the system',
                'password.required'=>'Password is required'
            ]);

        }
        $creds = array(
            $fieldType => $request->login_id,
            'password' =>$request->password
        );
        if (Auth::guard('admin')->attempt($creds)) {
            return redirect()->route('adminhome');
        }else{
            session()->flash('fail','Incorrect credentials');
            return redirect()->route('admin.login');
        }
    }

    public function logoutHandler(Request $request){
        Auth::guard('admin')->logout();
        session()->flash('fail','You are logged out!');
        return redirect()->route('adminlogin');

    }
    public function sendPasswordResetLink(Request $request){
        $request->validate([
            'email'=>'required|email|exists:admins,email'
        ],[
            'email.required'=>'The :attribute is required',
            'email.email'=>'Invalid Email address',
            'email.exists'=>'The :attribute does not exist in the system'
        ]);
        // get admin details
        $admin = Admin::where('email',$request->email)->first();
        //generate token
        $token = base64_encode(Str::random(64));
        //check if there's an existing reset password token
        $oldToken = DB::table('password_reset_tokens')
                        ->where(['email'=>$request->email,'guard'=>constGuards::ADMIN])
                        ->first();

        if ($oldToken) {
            //updte token
            DB::table('password_reset_tokens')
            ->where(['email'=>$request->email,'guard'=>constGuards::ADMIN])
                ->update([
                    'token'=>$token,
                    'created_at'=>Carbon::now()
                ]);
        }else{
            DB::table('password_reset_tokens')->insert([
                'email'=>$request->email,
                'guard'=>constGuards::ADMIN,
                'token'=>$token,
                'created_at'=>Carbon::now()
            ]);
        }

        $actionLink = route('adminreset-password',['token'=>$token,'email'=>$request->email]);

        $data = array(
            'actionLink'=>$actionLink,
            'admin'=>$admin
        );
        $mail_body = view('email-templates.admin-forgot-email-template',$data)->render();

        $mailConfig = array(
            'mail_from_email'=>'EMAIL_FROM_ADDRESS',
            'mail_from_name'=>'EMAIL_FROM_NAME',
            'mail_recipient_email'=>$admin->email,
            'mail_recipient_name'=>$admin->name,
            'mail_subject'=>'Reset Password',
            'mail_body'=>$mail_body
        );
        if(sendEmail($mailConfig)){
            session()->flash('success','We have e-mailed your password reset link');
            return redirect()->route('adminforgot-password');
        }else{
            session()->flash('fail','Something went wrong!');
            return redirect()->route('adminforgot-password');
        }
    }
}
