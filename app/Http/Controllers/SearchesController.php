<?php namespace JobApis\JobsToMail\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\URL;
use JobApis\JobsToMail\Jobs\Searches\Delete;
use JobApis\JobsToMail\Jobs\Searches\GetUserSearches;

class SearchesController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * View a user's searches
     */
    public function index(Request $request, $userId = null)
    {
        // Get the searches for this user (or specified in ID)
        $results = $this->dispatchNow(
            new GetUserSearches(
                $userId ?: $request->session()->get('user.id')
            )
        );

        if (!$results->isEmpty()) {
            return view('searches.index', ['searches' => $results]);
        }

        $request->session()->flash('alert-danger', 'You currently have no active searches. Try adding one.');

        return redirect('/');
    }

    /**
     * Unsubscribe from single search
     */
    public function unsubscribe(Request $request, $searchId)
    {
        $message = $this->dispatchNow(new Delete($searchId));

        $request->session()->flash($message->type, $message->message);

        return redirect(URL::previous('/'));
    }
}
