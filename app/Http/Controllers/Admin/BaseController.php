<?php

namespace sneakypanel\Http\Controllers\Admin;

use Illuminate\View\View;
use Illuminate\View\Factory as ViewFactory;
use sneakypanel\Http\Controllers\Controller;
use sneakypanel\Services\Helpers\SoftwareVersionService;

class BaseController extends Controller
{
    /**
     * BaseController constructor.
     */
    public function __construct(private SoftwareVersionService $version, private ViewFactory $view)
    {
    }

    /**
     * Return the admin index view.
     */
    public function index(): View
    {
        return $this->view->make('admin.index', ['version' => $this->version]);
    }
}
