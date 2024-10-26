<?php

namespace sneakypanel\Services\Locations;

use Webmozart\Assert\Assert;
use sneakypanel\Models\Location;
use sneakypanel\Contracts\Repository\NodeRepositoryInterface;
use sneakypanel\Contracts\Repository\LocationRepositoryInterface;
use sneakypanel\Exceptions\Service\Location\HasActiveNodesException;

class LocationDeletionService
{
    /**
     * LocationDeletionService constructor.
     */
    public function __construct(
        protected LocationRepositoryInterface $repository,
        protected NodeRepositoryInterface $nodeRepository,
    ) {
    }

    /**
     * Delete an existing location.
     *
     * @throws HasActiveNodesException
     */
    public function handle(Location|int $location): ?int
    {
        $location = ($location instanceof Location) ? $location->id : $location;

        Assert::integerish($location, 'First argument passed to handle must be numeric or an instance of ' . Location::class . ', received %s.');

        $count = $this->nodeRepository->findCountWhere([['location_id', '=', $location]]);
        if ($count > 0) {
            throw new HasActiveNodesException(trans('exceptions.locations.has_nodes'));
        }

        return $this->repository->delete($location);
    }
}
