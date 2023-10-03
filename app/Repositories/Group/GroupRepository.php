<?php

namespace Vanguard\Repositories\Group;

use Carbon\Carbon;
use Vanguard\Group;

interface GroupRepository
{
    /**
     * Paginate registered groups.
     *
     * @param $perPage
     * @param null $search
     * @param null $status
     * @return mixed
     */
    public function paginate($perPage, $search = null, $status = null);

    /**
     * Find group by its id.
     *
     * @param $id
     * @return null|Group
     */
    public function find($id);

    /**
     * Create new group.
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Update group specified by it's id.
     *
     * @param $id
     * @param array $data
     * @return Group
     */
    public function update($id, array $data);

    /**
     * Delete group with provided id.
     *
     * @param $id
     * @return mixed
     */
    public function delete($id);


    /**
     * Number of groups in database.
     *
     * @return mixed
     */
    public function count();

    /**
     * Number of groups registered during current month.
     *
     * @return mixed
     */
    public function newGroupsCount();

    /**
     * Number of groups with provided status.
     *
     * @param $status
     * @return mixed
     */
    public function countByStatus($status);

    /**
     * Count of registered groups for every month within the
     * provided date range.
     *
     * @param $from
     * @param $to
     * @return mixed
     */
    public function countOfNewGroupsPerMonth(Carbon $from, Carbon $to);

    /**
     * Get latest {$count} groups from database.
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
    public function lists($column = 'group', $key = 'id');
  }
  