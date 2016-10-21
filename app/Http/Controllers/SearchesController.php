<?php namespace JobApis\JobsToMail\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\URL;
use JobApis\JobsToMail\Jobs\DeleteSearch;

class SearchesController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * Unsubscribe from single search
     */
    public function unsubscribe(Request $request, $searchId)
    {
        $message = $this->dispatchNow(new DeleteSearch($searchId));

        $request->session()->flash($message->type, $message->message);

        return redirect(URL::previous('/'));
    }
}
