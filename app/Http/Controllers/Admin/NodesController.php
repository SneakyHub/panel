<?php

namespace sneakypanel\Http\Controllers\Admin;

use Illuminate\View\View;
use Illuminate\Http\Request;
use sneakypanel\Models\Node;
use Illuminate\Http\Response;
use sneakypanel\Models\Allocation;
use Illuminate\Http\RedirectResponse;
use Prologue\Alerts\AlertsMessageBag;
use Illuminate\View\Factory as ViewFactory;
use sneakypanel\Http\Controllers\Controller;
use sneakypanel\Services\Nodes\NodeUpdateService;
use Illuminate\Cache\Repository as CacheRepository;
use sneakypanel\Services\Nodes\NodeCreationService;
use sneakypanel\Services\Nodes\NodeDeletionService;
use sneakypanel\Services\Allocations\AssignmentService;
use sneakypanel\Services\Helpers\SoftwareVersionService;
use sneakypanel\Http\Requests\Admin\Node\NodeFormRequest;
use sneakypanel\Contracts\Repository\NodeRepositoryInterface;
use sneakypanel\Contracts\Repository\ServerRepositoryInterface;
use sneakypanel\Http\Requests\Admin\Node\AllocationFormRequest;
use sneakypanel\Services\Allocations\AllocationDeletionService;
use sneakypanel\Contracts\Repository\LocationRepositoryInterface;
use sneakypanel\Contracts\Repository\AllocationRepositoryInterface;
use sneakypanel\Http\Requests\Admin\Node\AllocationAliasFormRequest;

class NodesController extends Controller
{
    /**
     * NodesController constructor.
     */
    public function __construct(
        protected AlertsMessageBag $alert,
        protected AllocationDeletionService $allocationDeletionService,
        protected AllocationRepositoryInterface $allocationRepository,
        protected AssignmentService $assignmentService,
        protected CacheRepository $cache,
        protected NodeCreationService $creationService,
        protected NodeDeletionService $deletionService,
        protected LocationRepositoryInterface $locationRepository,
        protected NodeRepositoryInterface $repository,
        protected ServerRepositoryInterface $serverRepository,
        protected NodeUpdateService $updateService,
        protected SoftwareVersionService $versionService,
        protected ViewFactory $view,
    ) {
    }

    /**
     * Displays create new node page.
     */
    public function create(): View|RedirectResponse
    {
        $locations = $this->locationRepository->all();
        if (count($locations) < 1) {
            $this->alert->warning(trans('admin/node.notices.location_required'))->flash();

            return redirect()->route('admin.locations');
        }

        return $this->view->make('admin.nodes.new', ['locations' => $locations]);
    }

    /**
     * Post controller to create a new node on the system.
     *
     * @throws \sneakypanel\Exceptions\Model\DataValidationException
     */
    public function store(NodeFormRequest $request): RedirectResponse
    {
        $node = $this->creationService->handle($request->normalize());
        $this->alert->info(trans('admin/node.notices.node_created'))->flash();

        return redirect()->route('admin.nodes.view.allocation', $node->id);
    }

    /**
     * Updates settings for a node.
     *
     * @throws \sneakypanel\Exceptions\DisplayException
     * @throws \sneakypanel\Exceptions\Model\DataValidationException
     * @throws \sneakypanel\Exceptions\Repository\RecordNotFoundException
     */
    public function updateSettings(NodeFormRequest $request, Node $node): RedirectResponse
    {
        $this->updateService->handle($node, $request->normalize(), $request->input('reset_secret') === 'on');
        $this->alert->success(trans('admin/node.notices.node_updated'))->flash();

        return redirect()->route('admin.nodes.view.settings', $node->id)->withInput();
    }

    /**
     * Removes a single allocation from a node.
     *
     * @throws \sneakypanel\Exceptions\Service\Allocation\ServerUsingAllocationException
     */
    public function allocationRemoveSingle(int $node, Allocation $allocation): Response
    {
        $this->allocationDeletionService->handle($allocation);

        return response('', 204);
    }

    /**
     * Removes multiple individual allocations from a node.
     *
     * @throws \sneakypanel\Exceptions\Service\Allocation\ServerUsingAllocationException
     */
    public function allocationRemoveMultiple(Request $request, int $node): Response
    {
        $allocations = $request->input('allocations');
        foreach ($allocations as $rawAllocation) {
            $allocation = new Allocation();
            $allocation->id = $rawAllocation['id'];
            $this->allocationRemoveSingle($node, $allocation);
        }

        return response('', 204);
    }

    /**
     * Remove all allocations for a specific IP at once on a node.
     */
    public function allocationRemoveBlock(Request $request, int $node): RedirectResponse
    {
        $this->allocationRepository->deleteWhere([
            ['node_id', '=', $node],
            ['server_id', '=', null],
            ['ip', '=', $request->input('ip')],
        ]);

        $this->alert->success(trans('admin/node.notices.unallocated_deleted', ['ip' => htmlspecialchars($request->input('ip'))]))
            ->flash();

        return redirect()->route('admin.nodes.view.allocation', $node);
    }

    /**
     * Sets an alias for a specific allocation on a node.
     *
     * @throws \sneakypanel\Exceptions\Model\DataValidationException
     * @throws \sneakypanel\Exceptions\Repository\RecordNotFoundException
     */
    public function allocationSetAlias(AllocationAliasFormRequest $request): \Symfony\Component\HttpFoundation\Response
    {
        $this->allocationRepository->update($request->input('allocation_id'), [
            'ip_alias' => (empty($request->input('alias'))) ? null : $request->input('alias'),
        ]);

        return response('', 204);
    }

    /**
     * Creates new allocations on a node.
     *
     * @throws \sneakypanel\Exceptions\Service\Allocation\CidrOutOfRangeException
     * @throws \sneakypanel\Exceptions\Service\Allocation\InvalidPortMappingException
     * @throws \sneakypanel\Exceptions\Service\Allocation\PortOutOfRangeException
     * @throws \sneakypanel\Exceptions\Service\Allocation\TooManyPortsInRangeException
     */
    public function createAllocation(AllocationFormRequest $request, Node $node): RedirectResponse
    {
        $this->assignmentService->handle($node, $request->normalize());
        $this->alert->success(trans('admin/node.notices.allocations_added'))->flash();

        return redirect()->route('admin.nodes.view.allocation', $node->id);
    }

    /**
     * Deletes a node from the system.
     *
     * @throws \sneakypanel\Exceptions\DisplayException
     */
    public function delete(int|Node $node): RedirectResponse
    {
        $this->deletionService->handle($node);
        $this->alert->success(trans('admin/node.notices.node_deleted'))->flash();

        return redirect()->route('admin.nodes');
    }
}
