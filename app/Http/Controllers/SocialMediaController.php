<?php

namespace App\Http\Controllers;

use App\Model\SocialMedia;

class SocialMediaController extends Controller
{
    public function index() {
        return view('mastodon');
    }
}
