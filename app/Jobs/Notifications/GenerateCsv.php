<?php namespace JobApis\JobsToMail\Jobs\Notifications;

use JobApis\JobsToMail\Filters\JobFilter;
use JobApis\JobsToMail\Models\CustomDatabaseNotification;
use League\Csv\Writer;

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
        'source',
        'datePosted',
    ];

    /**
     * @var string $id Notification ID
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
     * Generate a CSV a single notification and return the file path
     *
     * @return string file path for download
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
        return $this->createCsv($csv, $jobs, $this->id.'.csv');
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
        if (file_exists($path)) {
            $csv = $csv->createFromPath($path, 'rx+');
        } else {
            $csv = $csv->createFromPath($path, 'x+');
        }

        // Add header rows
        $csv->insertOne(array_keys($items[0]));

        // Add each item as a new line to the CSV
        $csv->insertAll($items);

        return $path;
    }
}
