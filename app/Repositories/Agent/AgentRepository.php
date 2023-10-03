<?php

namespace Vanguard\Repositories\Agent;

use Carbon\Carbon;
use Vanguard\Agent;

interface AgentRepository
{
    /**
     * Paginate registered Agents.
     *
     * @param $perPage
     * @param null $search
     * @param null $status
     * @return mixed
     */
    public function paginate($perPage, $search = null, $status = null);

    /**
     * Find Agent by its id.
     *
     * @param $id
     * @return null|Agent
     */
    public function find($id);

    /**
     * Create new Agent.
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Update Agent specified by it's id.
     *
     * @param $id
     * @param array $data
     * @return Agent
     */
    public function update($id, array $data);

    /**
     * Delete Agent with provided id.
     *
     * @param $id
     * @return mixed
     */
    public function delete($id);

    
    /**
     * Number of Agents in database.
     *
     * @return mixed
     */
    public function count();

    /**
     * Number of Agents registered during current month.
     *
     * @return mixed
     */
    public function newAgentsCount();

    /**
     * Number of Agents with provided status.
     *
     * @param $status
     * @return mixed
     */
    public function countByStatus($status);

        /**
     * Number of Agents with a relay active.
     *
     * @param $status
     * @return mixed
     */
        public function countActiveRelays();

    /**
     * Count of registered Agents for every month within the
     * provided date range.
     *
     * @param $from
     * @param $to
     * @return mixed
     */
    public function countOfNewAgentsPerMonth(Carbon $from, Carbon $to);

    /**
     * Get latest {$count} Agents from database.
     *
     * @param $count
     * @return mixed
     */
    public function latest($count = 20);

     /** Lists all handlers into $key => $column value pairs.
     *
     * @param string $column
     * @param string $key
     * @return mixed
     */
     public function lists($column = 'name', $key = 'id');


}