<?php namespace JobApis\JobsToMail\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use JobApis\JobsToMail\Repositories\Contracts\UserRepositoryInterface;

class UsersController extends BaseController
{
    use ValidatesRequests;

    public function __construct(UserRepositoryInterface $users)
    {
        $this->users = $users;
    }

    /**
     * Create new User.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $rules = [
            'email' => 'required',
            'keyword' => 'required',
            'location' => 'required',
        ];

        $data = $request->only(array_keys($rules));

        $this->validate($request, $rules);

        return $this->users->create($data)->toArray();
    }
}
