<?php

namespace Vanguard\Events\AgentNotes;

use Vanguard\AgentNotes;

class Created
{
    /**
     * @var AgentNotes
     */
    protected $createdAgentNotes;

    public function __construct(AgentNotes $createdAgentNotes)
    {
        $this->createdAgentNotes = $createdAgentNotes;
    }

    /**
     * @return AgentNotes
     */
    public function getCreatedAgentNotes()
    {
        return $this->createdAgentNotes;
    }
}
