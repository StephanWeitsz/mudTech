<?php

namespace Mudtec\Ezimeeting\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CorpuserController extends Controller
{
    public function list()
    {
        return view('ezimeeting::admin.users.corpUser');
    }

    public function edit($user)
    {
        $page_heading = 'Users';
        $page_sub_heading = 'Update User';
        return view('ezimeeting::admin.users.corpUserEdit', compact('user','page_heading','page_sub_heading'));
    }

}

