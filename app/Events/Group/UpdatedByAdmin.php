<?php

namespace Vanguard\Events\Group;

use Vanguard\Group;

class UpdatedByAdmin
{
    /**
     * @var Group
     */
    protected $updatedGroup;

    public function __construct(Group $updatedGroup)
    {
        $this->updatedGroup = $updatedGroup;
    }

    /**
     * @return Group
     */
    public function getUpdatedGroup()
    {
        return $this->updatedGroup;
    }
}
