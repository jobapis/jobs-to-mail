<?php namespace JobApis\JobsToMail\Http\Messages;

class FlashMessage
{
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
    public function __construct($type = null, $message = null)
    {
        if ($type && in_array($type, $this->getTypes())) {
            $this->type = $type;
            $this->message = $message;
        } else {
            throw new \OutOfBoundsException("Invalid type {$type} specified.");
        }
    }

    /**
     * Valid types
     *
     * @return array
     */
    public function getTypes()
    {
        return [
            'alert-danger',
            'alert-success',
        ];
    }
}
