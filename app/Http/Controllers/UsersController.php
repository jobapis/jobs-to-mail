<?php namespace JobApis\JobsToMail\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use JobApis\JobsToMail\Http\Requests\CreateUser;
use JobApis\JobsToMail\Jobs\ConfirmUser;
use JobApis\JobsToMail\Jobs\CreateUserAndSearch;
use JobApis\JobsToMail\Repositories\Contracts\UserRepositoryInterface;

class UsersController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * UsersController constructor.
     */
    public function __construct(UserRepositoryInterface $users)
    {
        $this->users = $users;
    }

    /**
     * Home page and signup form
     */
    public function index()
    {
        return view('users.welcome');
    }

    /**
     * Create new User.
     */
    public function create(CreateUser $request)
    {
        $data = $request->only(array_keys($request->rules()));

        $message = $this->dispatchNow(new CreateUserAndSearch($data));

        $request->session()->flash($message->type, $message->message);

        return redirect('/');
    }

    /**
     * Confirm user account
     */
    public function confirm(Request $request, $token)
    {
        $message = $this->dispatchNow(new ConfirmUser($token));

        $request->session()->flash($message->type, $message->message);

        return redirect('/');
    }

    /**
     * Unsubscribe user account
     */
    public function unsubscribe(Request $request, $userId)
    {
        if ($this->users->unsubscribe($userId)) {
            $request->session()->flash(
                'alert-success',
                'Your job search has been cancelled. If you\'d like to create a new search, fill out the form below.'
            );
        } else {
            $request->session()->flash(
                'alert-danger',
                'We couldn\'t unsubscribe you. Please try again.'
            );
        }
        return redirect('/');
    }
}
