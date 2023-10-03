<?php

namespace Vanguard\Events\Group;

use Vanguard\Group;

class Created
{
    /**
     * @var Group
     */
    protected $createdGroup;

    public function __construct(User $createdGroup)
    {
        $this->createdGroup = $createdGroup;
    }

    /**
     * @return Group
     */
    public function getCreatedGroup()
    {
        return $this->createdGroup;
    }
}
