<?php

namespace Vanguard\Events\Handler;

use Vanguard\Handler;

class UpdatedByAdmin
{
    /**
     * @var Handler
     */
    protected $updatedHandler;

    public function __construct(Handler $updatedHandler)
    {
        $this->updatedHandler = $updatedHandler;
    }

    /**
     * @return Handler
     */
    public function getUpdatedHandler()
    {
        return $this->updatedHandler;
    }
}
