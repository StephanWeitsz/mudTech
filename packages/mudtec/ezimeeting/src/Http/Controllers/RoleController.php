<?php

namespace Mudtec\Ezimeeting\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function roles()
    {
        return view('ezimeeting::admin.roles.role');
    }

    public function create() {
        return view('ezimeeting::admin.roles.roleCreate');
    }

    public function role($role) {
        return view('ezimeeting::admin.roles.roleEdit', ['role' => $role]);
    }

}

