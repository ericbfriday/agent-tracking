<?php

namespace Vanguard\Repositories\AgentNotes;

use Carbon\Carbon;
use Vanguard\AgentNotes;

interface AgentNotesRepository
{
    /**
     * Paginate registered AgentNotess.
     *
     * @param $perPage
     * @param null $search
     * @param null $status
     * @return mixed
     */
    public function paginate($perPage, $search = null, $status = null);

    /**
     * Find AgentNotes by its id.
     *
     * @param $id
     * @return null|AgentNotes
     */
    public function find($id);

    /**
     * Create new AgentNotes.
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Update AgentNotes specified by it's id.
     *
     * @param $id
     * @param array $data
     * @return AgentNotes
     */
    public function update($id, array $data);

    /**
     * Delete AgentNotes with provided id.
     *
     * @param $id
     * @return mixed
     */
    public function delete($id);


    /**
     * Number of AgentNotess in database.
     *
     * @return mixed
     */
    public function count();

    /**
     * Number of AgentNotess registered during current month.
     *
     * @return mixed
     */
    public function newAgentNotessCount();

    /**
     * Number of AgentNotess with provided status.
     *
     * @param $status
     * @return mixed
     */
    public function countByStatus($status);

    /**
     * Count of registered AgentNotess for every month within the
     * provided date range.
     *
     * @param $from
     * @param $to
     * @return mixed
     */
    public function countOfNewAgentNotessPerMonth(Carbon $from, Carbon $to);

    /**
     * Get latest {$count} AgentNotess from database.
     *
     * @param $count
     * @return mixed
     */
    public function latest($count = 20);

        /**
     * Lists all groups into $key => $column value pairs.
     *
     * @param string $column
     * @param string $key
     * @return mixed
     */
    public function lists($column = 'agent', $key = 'id');

    }