<?php

namespace Mudtec\Ezimeeting\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CorporationController extends Controller
{
    public function corporations()
    {
        return view('ezimeeting::admin.corporations.corporation');
    }

    public function create() {
        return view('ezimeeting::admin.corporations.corporationCreate');
    }

    public function update($corporation) {
        return view('ezimeeting::admin.corporations.corporationUpdate', ['corporation' => $corporation]);
    }

    public function users() {
        return view('ezimeeting::admin.corporations.corporationUser');
    }

}

