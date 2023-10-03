<?php

namespace Vanguard\Events\Handler;

use Vanguard\Handler;

class Created
{
    /**
     * @var Handler
     */
    protected $createdHandler;

    public function __construct(Handler $createdHandler)
    {
        $this->createdHandler = $createdHandler;
    }

    /**
     * @return Handler
     */
    public function getCreatedHandler()
    {
        return $this->createdHandler;
    }
}
