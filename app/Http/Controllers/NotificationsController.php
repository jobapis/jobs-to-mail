<?php namespace JobApis\JobsToMail\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use JobApis\JobsToMail\Jobs\Notifications\GenerateCsv;
use JobApis\JobsToMail\Jobs\Notifications\GetNotificationById;

class NotificationsController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * Show the notification
     */
    public function single(Request $request, $id)
    {
        $notification = $this->dispatchNow(new GetNotificationById($id));

        if ($notification) {
            return view('notifications.single', ['notification' => $notification]);
        }

        $request->session()->flash('alert-danger', 'This job alert has expired.');

        return redirect('/');
    }

    /**
     * Download jobs from a collection by ID
     */
    public function download(Request $request, $id)
    {
        $path = $this->dispatchNow(new GenerateCsv($id));

        return response()->download($path, null, ['Content-Type: text/csv']);
    }
}
