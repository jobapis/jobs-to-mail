<?php namespace JobApis\JobsToMail\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use JobApis\JobsToMail\Http\Requests\CreateUser;
use JobApis\JobsToMail\Repositories\Contracts\UserRepositoryInterface;

class UsersController extends BaseController
{
    use ValidatesRequests;

    /**
     * UsersController constructor.
     *
     * @param UserRepositoryInterface $users
     */
    public function __construct(UserRepositoryInterface $users)
    {
        $this->users = $users;
    }

    /**
     * Home page and signup form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('users.welcome');
    }

    /**
     * Show all users (for testing only)
     *
     * @return string Json of all users
     */
    public function all()
    {
        return response()->json(
            \JobApis\JobsToMail\Models\User::with('tokens')->get()
        );
    }

    /**
     * Create new User.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function create(CreateUser $request)
    {
        $data = $request->only(array_keys($request->rules()));

        if($user = $this->users->create($data)) {
            $request->session()->flash('alert-success', 'A confirmation email has been sent. Once confirmed, you will start receiving job listings within 24 hours.');
            return redirect('/');
        }
        return response("Invalid data", 400);
    }
}
