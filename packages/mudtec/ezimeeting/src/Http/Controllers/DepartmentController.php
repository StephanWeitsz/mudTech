<?php

namespace Mudtec\Ezimeeting\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function corporations()
    {
        return view('ezimeeting::admin.departments.corporations');
    }

    public function departments($corporation)
    {
        return view('ezimeeting::admin.departments.department', ['corporation' => $corporation]);
    }

    public function create($corporation) {
        return view('ezimeeting::admin.departments.departmentCreate', ['corporation' => $corporation]);
    }

    public function update($corporation, $department) {
        return view('ezimeeting::admin.departments.departmentUpdate', ['corporation' => $corporation, 'department' => $department]);
    }

    public function manager() {
        return view('ezimeeting::admin.departments.departmentManager');
    }
}

