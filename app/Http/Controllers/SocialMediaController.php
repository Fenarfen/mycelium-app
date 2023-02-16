<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamContact;

class SocialMediaController extends Controller
{


    public function TwitterPostStatus()
    {
        #post request, must be json
        #follow accept -> withHeaders -> post
        $response = \Illuminate\Support\Facades\Http::accept('application/json')->withHeaders([
            'Authorization' => 'Bearer ' . getenv('MASTODON_TEST_ACCESS')
        ])->post('https://api.twitter.com/2/tweets', [
            'text' => 'hello from php',
        ]);

        if (isset($response['id']))
            return "success";
        else if (isset($response['error']))
            return "failure";
        else
            return "Error: no response";
    }

    public function MastodonPostStatus()
    {
        #post request, must be json
        #follow accept -> withHeaders -> post
        $response = \Illuminate\Support\Facades\Http::accept('application/json')->withHeaders([
            'Authorization' => 'Bearer ' . getenv('MASTODON_TEST_ACCESS')
        ])->post('https://mastodon.social/api/v1/statuses', [
            'status' => 'hello from php',
        ]);

        if (isset($response['id']))
            return "success";
        else if (isset($response['error']))
            return "failure";
        else
            return "Error: no response";
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
