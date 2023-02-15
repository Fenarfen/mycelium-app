<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class sharkController extends Controller
{
    public function shark()
    {
        return view('sharks', ['animal' => 'shargndkfnjdk']);
    }
}
