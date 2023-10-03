<?php

namespace Vanguard\Events\Agent;

use Vanguard\Agent;

class Deleted
{
    /**
     * @var Agent
     */
    protected $deletedAgent;

    public function __construct(Agent $deletedAgent)
    {
        $this->deletedAgent = $deletedAgent;
    }

    /**
     * @return Agent
     */
    public function getDeletedAgent()
    {
        return $this->deletedAgent;
    }
}
