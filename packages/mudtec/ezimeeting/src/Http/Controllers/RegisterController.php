<?php

namespace Mudtec\Ezimeeting\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function register() {

        Log::info("Registering User in Corporation");
        return view('ezimeeting::registration.corporationRegister');
    }
}

