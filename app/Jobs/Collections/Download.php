<?php namespace JobApis\JobsToMail\Jobs\Collections;

use JobApis\JobsToMail\Http\Messages\FlashMessage;
use JobApis\JobsToMail\Models\CustomDatabaseNotification;
use League\Csv\Writer;
use Ramsey\Uuid\Uuid;

class Download
{
    /**
     * @var array $csvHeaders
     */
    protected $csvHeaders = [
        'name',
        'description',
        'url',
        'company',
        'location',
        'query',
        'industry',
        'datePosted',
    ];

    /**
     * @var string $id Collection ID
     */
    protected $id;

    /**
     * Create a new job instance.
     */
    public function __construct($id = null)
    {
        $this->id = $id;
    }

    /**
     * Download a single notification by ID
     *
     * @return FlashMessage
     */
    public function handle(CustomDatabaseNotification $notifications, Writer $csv)
    {
        // Get the jobs from the Database
        $jobs = $notifications->where('id', $this->id)->first()->data;

        // Filter raw jobs array - Move to filter class
        foreach ($jobs as &$job) {
            $job = array_filter($job, function ($key) {
                return in_array($key, $this->csvHeaders);
            }, ARRAY_FILTER_USE_KEY);
        }

        // Compose a CSV with all the jobs
        $path = $this->createCsv($csv, $jobs, Uuid::uuid4().'.csv');

        dd($path);
    }

    private function createCsv(Writer $csv, array $items = [], $filename = null)
    {
        // Make sure line endings are detected.
        if (!ini_get("auto_detect_line_endings")) {
            ini_set("auto_detect_line_endings", '1');
        }

        // Set the path for the csv to save
        $path = storage_path('app/'.$filename);

        // Open/create the file
        fopen($path, 'a') or die("Can't create file");

        // Instantiate a new csv writer
        $csv = $csv->createFromPath($path, 'a+');

        // Add header rows
        $csv->insertOne(array_keys($items[0]));

        // Add each item as a new line to the CSV
        $csv->insertAll($items);

        return $path;
    }
}
