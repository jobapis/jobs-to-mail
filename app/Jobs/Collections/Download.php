<?php namespace JobApis\JobsToMail\Jobs\Collections;

use JobApis\JobsToMail\Http\Messages\FlashMessage;

class Download
{
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
    public function handle()
    {
        //
        dd($this->id);
    }
}
