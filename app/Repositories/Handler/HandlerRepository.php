<?php

namespace Vanguard\Repositories\Handler;

use Carbon\Carbon;
use Vanguard\Handler;

interface HandlerRepository
{
    /**
     * Paginate registered Handlers.
     *
     * @param $perPage
     * @param null $search
     * @param null $status
     * @return mixed
     */
    public function paginate($perPage, $search = null, $status = null);

    /**
     * Find Handler by its id.
     *
     * @param $id
     * @return null|Handler
     */
    public function find($id);

    /**
     * Create new Handler.
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Update Handler specified by it's id.
     *
     * @param $id
     * @param array $data
     * @return Handler
     */
    public function update($id, array $data);

    /**
     * Delete Handler with provided id.
     *
     * @param $id
     * @return mixed
     */
    public function delete($id);


    /**
     * Number of Handlers in database.
     *
     * @return mixed
     */
    public function count();

    /**
     * Number of Handlers registered during current month.
     *
     * @return mixed
     */
    public function newHandlersCount();

    /**
     * Number of Handlers with provided status.
     *
     * @param $status
     * @return mixed
     */
    public function countByStatus($status);

    /**
     * Count of registered Handlers for every month within the
     * provided date range.
     *
     * @param $from
     * @param $to
     * @return mixed
     */
    public function countOfNewHandlersPerMonth(Carbon $from, Carbon $to);

    /**
     * Get latest {$count} Handlers from database.
     *
     * @param $count
     * @return mixed
     */
    public function latest($count = 20);

        /**
     * Lists all handlers into $key => $column value pairs.
     *
     * @param string $column
     * @param string $key
     * @return mixed
     */
        public function lists($column = 'username', $key = 'id');
    }