<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeProductController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([""])
    }
}
