<?php

namespace Modules\Admin\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\Admin\Service\AdminService;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class MaintenanceController extends Controller
{
    public function __construct(AdminService $adminService)
    {
        $this->middleware('auth:admin');
        $this->middleware('role:Super Admin');
        $this->adminService = $adminService;
    }

    public function toggle()
    {
        $maintenanceFilePath = storage_path('framework/maintenance.php');

        if (File::exists($maintenanceFilePath)) {
            Artisan::call('up');
            return returnMessage(true, 'Application is now running',['maintenance_mode' => false]);
        } else {
            Artisan::call('down');
            return returnMessage(true, 'Application is now in maintenance mode',['maintenance_mode' => true]);
        }
    }

    public function status()
    {
        $maintenanceFilePath = storage_path('framework/maintenance.php');
        $isInMaintenance = File::exists($maintenanceFilePath);

        return returnMessage(true, 'Application is in maintenance mode',['maintenance_mode' => $isInMaintenance]);
    }
}
