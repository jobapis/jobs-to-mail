<?php namespace JobApis\JobsToMail\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use JobApis\JobsToMail\Http\Requests\LoginUser;
use JobApis\JobsToMail\Jobs\Auth\LoginUserWithToken;
use JobApis\JobsToMail\Jobs\Auth\SendLoginMessage;

class AuthController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * View login form.
     */
    public function viewLogin(Request $request)
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

        return redirect('/confirm');
    }

    /**
     * Log out
     */
    public function logout(Request $request)
    {
        $request->session()->invalidate();

        $request->session()->flash('alert-success', 'You have been successfully logged out.');

        return redirect('/');
    }

    /**
     * Forward posts on to confirm endpoint with token
     */
    public function postConfirm(Request $request)
    {
        return $this->confirm($request, $request->only('token')['token']);
    }

    /**
     * Login a user via token
     */
    public function confirm(Request $request, $token)
    {
        $message = $this->dispatchNow(new LoginUserWithToken($token));

        $request->session()->flash($message->type, $message->message);

        return redirect('/');
    }
}
