<?php namespace JobApis\JobsToMail\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use JobApis\JobsToMail\Http\Requests\CreateUser;
use JobApis\JobsToMail\Jobs\CreateUserAndSearch;
use JobApis\JobsToMail\Jobs\DeleteUser;
use JobApis\JobsToMail\Jobs\GetUserSearches;

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
     * Delete a user account (and unsubscribe from all searches)
     */
    public function delete(Request $request, $userId)
    {
        $message = $this->dispatchNow(new DeleteUser($userId));

        $request->session()->flash($message->type, $message->message);

        return redirect('/');
    }

    /**
     * View searches for this user
     */
    public function searches(Request $request, $userId)
    {
        $results = $this->dispatchNow(new GetUserSearches($userId));

        if (!$results->isEmpty()) {
            return view('searches.index', ['searches' => $results]);
        }

        return redirect('/');
    }
}
