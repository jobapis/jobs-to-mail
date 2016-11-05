<?php namespace JobApis\JobsToMail\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\URL;
use JobApis\JobsToMail\Jobs\Collections\Download;

class CollectionsController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * Download jobs from a collection by ID
     */
    public function download(Request $request, $id)
    {
        $message = $this->dispatchNow(new Download($id));

        $request->session()->flash($message->type, $message->message);

        return redirect(URL::previous('/'));
    }
}
