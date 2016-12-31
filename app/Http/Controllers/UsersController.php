<?php namespace JobApis\JobsToMail\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use JobApis\JobsToMail\Http\Requests\CreateUser;
use JobApis\JobsToMail\Http\Requests\PremiumUser;
use JobApis\JobsToMail\Jobs\Users\CreateUserAndSearch;
use JobApis\JobsToMail\Jobs\Users\Delete;
use JobApis\JobsToMail\Jobs\Users\PremiumUserSignup;

class UsersController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

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
     * Delete a user account (unsubscribe from all searches)
     */
    public function delete(Request $request, $userId)
    {
        $message = $this->dispatchNow(new Delete($userId));

        $request->session()->flash($message->type, $message->message);

        return redirect('/');
    }

    /**
     * Show premium signup form
     */
    public function premium()
    {
        return view('users.premium');
    }

    /**
     * Post premium signup form
     */
    public function postPremium(PremiumUser $request)
    {
        $data = $request->only(array_keys($request->rules()));

        $message = $this->dispatchNow(new PremiumUserSignup($data));

        $request->session()->flash($message->type, $message->message);

        return redirect('/premium');
    }
}
