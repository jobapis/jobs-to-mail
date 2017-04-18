<?php namespace JobApis\JobsToMail\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use JobApis\JobsToMail\Models\CustomDatabaseNotification;

class DeleteNotifications extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:delete {--id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes old notifications from the database.';

    /**
     * @var CustomDatabaseNotification
     */
    public $notifications;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CustomDatabaseNotification $notifications)
    {
        parent::__construct();
        $this->notifications = $notifications;
    }

    /**
     * Goes through each user and queues up a task to collect and email them their jobs.
     *
     * @return mixed
     */
    public function handle()
    {
        $count = 0;
        if ($id = $this->option('id')) {
            $this->notifications->where("id", $id)->delete();
            $count++;
        } else {
            $results = $this->notifications->where("created_at", "<", Carbon::now()->subDays(7))->get();
            if ($results) {
                foreach ($results as $notification) {
                    $notification->delete();
                    $count++;
                }
            }
        }
        return $this->info("{$count} notifications deleted.");
    }
}
