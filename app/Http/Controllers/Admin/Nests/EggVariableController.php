<?php

namespace sneakypanel\Http\Controllers\Admin\Nests;

use Illuminate\View\View;
use sneakypanel\Models\Egg;
use sneakypanel\Models\EggVariable;
use Illuminate\Http\RedirectResponse;
use Prologue\Alerts\AlertsMessageBag;
use Illuminate\View\Factory as ViewFactory;
use sneakypanel\Http\Controllers\Controller;
use sneakypanel\Contracts\Repository\EggRepositoryInterface;
use sneakypanel\Services\Eggs\Variables\VariableUpdateService;
use sneakypanel\Http\Requests\Admin\Egg\EggVariableFormRequest;
use sneakypanel\Services\Eggs\Variables\VariableCreationService;
use sneakypanel\Contracts\Repository\EggVariableRepositoryInterface;

class EggVariableController extends Controller
{
    /**
     * EggVariableController constructor.
     */
    public function __construct(
        protected AlertsMessageBag $alert,
        protected VariableCreationService $creationService,
        protected VariableUpdateService $updateService,
        protected EggRepositoryInterface $repository,
        protected EggVariableRepositoryInterface $variableRepository,
        protected ViewFactory $view,
    ) {
    }

    /**
     * Handle request to view the variables attached to an Egg.
     *
     * @throws \sneakypanel\Exceptions\Repository\RecordNotFoundException
     */
    public function view(int $egg): View
    {
        $egg = $this->repository->getWithVariables($egg);

        return $this->view->make('admin.eggs.variables', ['egg' => $egg]);
    }

    /**
     * Handle a request to create a new Egg variable.
     *
     * @throws \sneakypanel\Exceptions\Model\DataValidationException
     * @throws \sneakypanel\Exceptions\Service\Egg\Variable\BadValidationRuleException
     * @throws \sneakypanel\Exceptions\Service\Egg\Variable\ReservedVariableNameException
     */
    public function store(EggVariableFormRequest $request, Egg $egg): RedirectResponse
    {
        $this->creationService->handle($egg->id, $request->normalize());
        $this->alert->success(trans('admin/nests.variables.notices.variable_created'))->flash();

        return redirect()->route('admin.nests.egg.variables', $egg->id);
    }

    /**
     * Handle a request to update an existing Egg variable.
     *
     * @throws \sneakypanel\Exceptions\DisplayException
     * @throws \sneakypanel\Exceptions\Model\DataValidationException
     * @throws \sneakypanel\Exceptions\Repository\RecordNotFoundException
     * @throws \sneakypanel\Exceptions\Service\Egg\Variable\ReservedVariableNameException
     */
    public function update(EggVariableFormRequest $request, Egg $egg, EggVariable $variable): RedirectResponse
    {
        $this->updateService->handle($variable, $request->normalize());
        $this->alert->success(trans('admin/nests.variables.notices.variable_updated', [
            'variable' => htmlspecialchars($variable->name),
        ]))->flash();

        return redirect()->route('admin.nests.egg.variables', $egg->id);
    }

    /**
     * Handle a request to delete an existing Egg variable from the Panel.
     */
    public function destroy(int $egg, EggVariable $variable): RedirectResponse
    {
        $this->variableRepository->delete($variable->id);
        $this->alert->success(trans('admin/nests.variables.notices.variable_deleted', [
            'variable' => htmlspecialchars($variable->name),
        ]))->flash();

        return redirect()->route('admin.nests.egg.variables', $egg);
    }
}
