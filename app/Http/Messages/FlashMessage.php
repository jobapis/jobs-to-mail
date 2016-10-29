<?php namespace JobApis\JobsToMail\Http\Messages;

class FlashMessage
{
    /**
     * Redirect location before showing this message
     *
     * @var string
     */
    public $location;

    /**
     * The message text
     *
     * @var string
     */
    public $message;

    /**
     * Type of message being created
     *
     * @var string
     */
    public $type;

    /**
     * FlashMessage constructor.
     *
     * @param null $type
     * @param null $message
     *
     * @throws \OutOfBoundsException
     */
    public function __construct($type = null, $message = null, $location = null)
    {
        if ($type && in_array($type, $this->getTypes())) {
            $this->type = $type;
            $this->message = $message;
            $this->location = $location;
        } else {
            throw new \OutOfBoundsException("Invalid type {$type} specified.");
        }
    }

    /**
     * Valid types
     *
     * @return array
     */
    protected function getTypes()
    {
        return [
            'alert-danger',
            'alert-success',
        ];
    }
}
