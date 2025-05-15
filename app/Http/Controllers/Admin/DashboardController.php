<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\DashboardRepo;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $dashboardRepo;
    private $view;
    public function __construct(DashboardRepo $dashboardRepo)
    {
        $this->dashboardRepo = $dashboardRepo;
        $this->view = 'admin.page.dashboard.';
    }

        /**
     * Returns the view for the admin layout.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function AdminLayout()
    {
        $data['header_title'] = 'Dashboard';
        $data['totalOrders'] = $this->dashboardRepo->getTotalOrders();
        $data['topSellingCategories'] = $this->dashboardRepo->getTopSellingCategories();
        $data['thisweeksReport'] = $this->dashboardRepo->getThisWeeksReport();
        // dd($data['thisweeksReport']);

        return view($this->view . 'index', ['data' => $data]);
    }
}
