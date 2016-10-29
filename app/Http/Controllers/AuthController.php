<?php namespace JobApis\JobsToMail\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use JobApis\JobsToMail\Http\Requests\LoginUser;
use JobApis\JobsToMail\Jobs\ConfirmUser;
use JobApis\JobsToMail\Jobs\Auth\SendLoginMessage;

class AuthController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * View login form.
     */
    public function viewLogin()
    {
        return view('auth.login');
    }

    /**
     * View token confirmation form.
     */
    public function viewConfirm()
    {
        return view('auth.confirm');
    }

    /**
     * Send user a login token
     */
    public function login(LoginUser $request)
    {
        $email = $request->only('email')['email'];

        $message = $this->dispatchNow(new SendLoginMessage($email));

        $request->session()->flash($message->type, $message->message);

        return redirect($message->location);
    }

    /**
     * Login a user via token
     */
    public function confirm(Request $request, $token)
    {
        $message = $this->dispatchNow(new ConfirmUser($token));

        $request->session()->flash($message->type, $message->message);

        return redirect('/');
    }
}
