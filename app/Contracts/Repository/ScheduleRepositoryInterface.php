<?php

namespace sneakypanel\Contracts\Repository;

use sneakypanel\Models\Schedule;
use Illuminate\Support\Collection;

interface ScheduleRepositoryInterface extends RepositoryInterface
{
    /**
     * Return all the schedules for a given server.
     */
    public function findServerSchedules(int $server): Collection;

    /**
     * Return a schedule model with all the associated tasks as a relationship.
     *
     * @throws \sneakypanel\Exceptions\Repository\RecordNotFoundException
     */
    public function getScheduleWithTasks(int $schedule): Schedule;
}
