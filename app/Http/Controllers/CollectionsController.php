<?php namespace JobApis\JobsToMail\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use JobApis\JobsToMail\Jobs\Collections\Download;

class CollectionsController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * Download jobs from a collection by ID
     */
    public function download(Request $request, $id)
    {
        $path = $this->dispatchNow(new Download($id));

        // sleep(2);

        return response()->download($path, null, ['Content-Type: text/csv']);
    }
}
