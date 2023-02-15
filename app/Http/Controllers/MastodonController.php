<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MastodonController extends Controller
{
    public function index()
    {
        return view('mastodon');
    }
}
