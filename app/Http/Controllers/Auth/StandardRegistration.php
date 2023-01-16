<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StandardRegistration extends Controller
{
    //
    public function standard(){
        return inertia::render('auth.standard');
    }
}
