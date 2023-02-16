<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamContact;

class SocialMediaController extends Controller
{
    public function index() {
        return view('mastodon');
    }

    /**
     * Show the attribute for a given teams contanct details.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $team = Team::find($id);
        $contacts = TeamContact::where('team_id', $team->id)->get();
        return view('team-contact', [
            'contacts' => $contacts,
            'team' => $team
        ]);
    }

    public function create() {
        $model = TeamContact::create(['team_id' => 1,
        'handle' => 'test3', 
        'website' => 'www.test3.com']);

        echo('contact created');
    }
}
