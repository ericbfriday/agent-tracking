<?php

namespace Vanguard\Events\Agent;

use Vanguard\Agent;

class UpdatedByAdmin
{
    /**
     * @var Agent
     */
    protected $updatedAgent;

    public function __construct(Agent $updatedAgent)
    {
        $this->updatedAgent = $updatedAgent;
    }

    /**
     * @return Agent
     */
    public function getUpdatedAgent()
    {
        return $this->updatedAgent;
    }
}
