<?php

namespace Vanguard\Events\Agent;

use Vanguard\Agent;

class Created
{
    /**
     * @var Agent
     */
    protected $createdAgent;

    public function __construct(Agent $createdAgent)
    {
        $this->createdAgent = $createdAgent;
    }

    /**
     * @return Agent
     */
    public function getCreatedAgent()
    {
        return $this->createdAgent;
    }
}
