<?php namespace JobApis\JobsToMail\Jobs\Collections;

use JobApis\JobsToMail\Filters\JobFilter;
use JobApis\JobsToMail\Http\Messages\FlashMessage;
use JobApis\JobsToMail\Models\CustomDatabaseNotification;
use League\Csv\Writer;
use Ramsey\Uuid\Uuid;

class GenerateCsv
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
    public function handle(
        CustomDatabaseNotification $notifications,
        JobFilter $jobFilter,
        Writer $csv
    ) {
        // Get the jobs from the Database
        $jobs = $notifications->where('id', $this->id)->first()->data;

        // Filter raw jobs array - Move to filter class
        $jobs = $jobFilter->filterFields($jobs, $this->csvHeaders);

        // Compose a CSV with all the jobs
        return $this->createCsv($csv, $jobs, Uuid::uuid4().'.csv');
    }

    private function createCsv(Writer $csv, array $items = [], $filename = null)
    {
        // Make sure line endings are detected.
        if (!ini_get("auto_detect_line_endings")) {
            ini_set("auto_detect_line_endings", '1');
        }

        // Set the path for the csv to save
        $path = storage_path('app/'.$filename);

        // Instantiate a new csv writer
        $csv = $csv->createFromPath($path, 'x+');

        // Add header rows
        $csv->insertOne(array_keys($items[0]));

        // Add each item as a new line to the CSV
        $csv->insertAll($items);

        return $path;
    }
}
