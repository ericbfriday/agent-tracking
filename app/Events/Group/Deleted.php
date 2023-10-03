<?php

namespace Vanguard\Events\Group;

use Vanguard\Group;

class Deleted
{
    /**
     * @var Group
     */
    protected $deletedGroup;

    public function __construct(Group $deletedGroup)
    {
        $this->deletedGroup = $deletedGroup;
    }

    /**
     * @return Group
     */
    public function getDeletedGroup()
    {
        return $this->deletedGroup;
    }
}
