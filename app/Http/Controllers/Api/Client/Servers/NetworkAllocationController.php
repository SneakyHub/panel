<?php

namespace sneakypanel\Http\Controllers\Api\Client\Servers;

use sneakypanel\Models\Server;
use Illuminate\Http\JsonResponse;
use sneakypanel\Facades\Activity;
use sneakypanel\Models\Allocation;
use sneakypanel\Exceptions\DisplayException;
use sneakypanel\Repositories\Eloquent\ServerRepository;
use sneakypanel\Transformers\Api\Client\AllocationTransformer;
use sneakypanel\Http\Controllers\Api\Client\ClientApiController;
use sneakypanel\Services\Allocations\FindAssignableAllocationService;
use sneakypanel\Http\Requests\Api\Client\Servers\Network\GetNetworkRequest;
use sneakypanel\Http\Requests\Api\Client\Servers\Network\NewAllocationRequest;
use sneakypanel\Http\Requests\Api\Client\Servers\Network\DeleteAllocationRequest;
use sneakypanel\Http\Requests\Api\Client\Servers\Network\UpdateAllocationRequest;
use sneakypanel\Http\Requests\Api\Client\Servers\Network\SetPrimaryAllocationRequest;

class NetworkAllocationController extends ClientApiController
{
    /**
     * NetworkAllocationController constructor.
     */
    public function __construct(
        private FindAssignableAllocationService $assignableAllocationService,
        private ServerRepository $serverRepository,
    ) {
        parent::__construct();
    }

    /**
     * Lists all the allocations available to a server and whether
     * they are currently assigned as the primary for this server.
     */
    public function index(GetNetworkRequest $request, Server $server): array
    {
        return $this->fractal->collection($server->allocations)
            ->transformWith($this->getTransformer(AllocationTransformer::class))
            ->toArray();
    }

    /**
     * Set the primary allocation for a server.
     *
     * @throws \sneakypanel\Exceptions\Model\DataValidationException
     * @throws \sneakypanel\Exceptions\Repository\RecordNotFoundException
     */
    public function update(UpdateAllocationRequest $request, Server $server, Allocation $allocation): array
    {
        $original = $allocation->notes;

        $allocation->forceFill(['notes' => $request->input('notes')])->save();

        if ($original !== $allocation->notes) {
            Activity::event('server:allocation.notes')
                ->subject($allocation)
                ->property(['allocation' => $allocation->toString(), 'old' => $original, 'new' => $allocation->notes])
                ->log();
        }

        return $this->fractal->item($allocation)
            ->transformWith($this->getTransformer(AllocationTransformer::class))
            ->toArray();
    }

    /**
     * Set the primary allocation for a server.
     *
     * @throws \sneakypanel\Exceptions\Model\DataValidationException
     * @throws \sneakypanel\Exceptions\Repository\RecordNotFoundException
     */
    public function setPrimary(SetPrimaryAllocationRequest $request, Server $server, Allocation $allocation): array
    {
        $this->serverRepository->update($server->id, ['allocation_id' => $allocation->id]);

        Activity::event('server:allocation.primary')
            ->subject($allocation)
            ->property('allocation', $allocation->toString())
            ->log();

        return $this->fractal->item($allocation)
            ->transformWith($this->getTransformer(AllocationTransformer::class))
            ->toArray();
    }

    /**
     * Set the notes for the allocation for a server.
     *s.
     *
     * @throws DisplayException
     */
    public function store(NewAllocationRequest $request, Server $server): array
    {
        if ($server->allocations()->count() >= $server->allocation_limit) {
            throw new DisplayException('Cannot assign additional allocations to this server: limit has been reached.');
        }

        $allocation = $this->assignableAllocationService->handle($server);

        Activity::event('server:allocation.create')
            ->subject($allocation)
            ->property('allocation', $allocation->toString())
            ->log();

        return $this->fractal->item($allocation)
            ->transformWith($this->getTransformer(AllocationTransformer::class))
            ->toArray();
    }

    /**
     * Delete an allocation from a server.
     *
     * @throws DisplayException
     */
    public function delete(DeleteAllocationRequest $request, Server $server, Allocation $allocation): JsonResponse
    {
        // Don't allow the deletion of allocations if the server does not have an
        // allocation limit set.
        if (empty($server->allocation_limit)) {
            throw new DisplayException('You cannot delete allocations for this server: no allocation limit is set.');
        }

        if ($allocation->id === $server->allocation_id) {
            throw new DisplayException('You cannot delete the primary allocation for this server.');
        }

        Allocation::query()->where('id', $allocation->id)->update([
            'notes' => null,
            'server_id' => null,
        ]);

        Activity::event('server:allocation.delete')
            ->subject($allocation)
            ->property('allocation', $allocation->toString())
            ->log();

        return new JsonResponse([], JsonResponse::HTTP_NO_CONTENT);
    }
}
