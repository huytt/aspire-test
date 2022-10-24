<?php

namespace Huytt\Core\Exceptions;

use Throwable;

class BaseException extends \Exception
{
    protected $messageCode;

    public function __construct($messageCode = "", $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->messageCode = $messageCode;
    }


    /**
     * @return mixed|string
     */
    public function getMessageCode()
    {
        return $this->messageCode;
    }

    /**
     * @param mixed|string $messageCode
     */
    public function setMessageCode($messageCode): void
    {
        $this->messageCode = $messageCode;
    }

}
