<p>Dear {{$admin->name}}</p>
<br/>
<p>
    Your password on the system was changed successfully.
    Here is your new login credentials:
    <br>
    <b>Login ID:</b>{{$admin->username}} or {{$admin->email}}
    <br>
    <b>Password:</b>{{$new_password}}

</p>
<br>
Please keep your credentials confidential. Your username and password is your own credentials and you should never share them with anybody.
<p>
    Our management are not liable for any misuse of your account
</p>
<br>
<p>
    This Email was automatically  sent by our system. Don't reply to this message.
</p>