<?php

namespace Vanguard\Events\Handler;

use Vanguard\Handler;

class Deleted
{
    /**
     * @var Handler
     */
    protected $deletedHandler;

    public function __construct(Handler $deletedHandler)
    {
        $this->deletedHandler = $deletedHandler;
    }

    /**
     * @return Handler
     */
    public function getDeletedHandler()
    {
        return $this->deletedHandler;
    }
}
