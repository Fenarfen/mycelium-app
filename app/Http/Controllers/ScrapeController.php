<?php

namespace App\Http\Controllers;

use Goutte\Client;
use App\Models\Team;
use App\Models\TeamContact;
use App\Traits\CreateTeamContact;

class ScrapeController extends Controller
{
    use CreateTeamContact;

    public function scrape()
    {
        $client = new Client();
        // Only takes the frist team from the database to test with at the moment
        $team = Team::all()->first(); 
        $website = $team->website;

        $crawler = $client->request('GET', $website);
            
        $facebook_link = $crawler->filter('a[title="Facebook"]')->last()->attr('href');
        $twitter_link = $crawler->filter('a[title="Twitter"]')->last()->attr('href');

        $contacts = [];

        // Get the handles by taking a substring at the correct length
        // e.g. https://facebook.com/ is removed
        $contacts[] = $this->verifyAndCreateTeamContact($team->id, substr($facebook_link, 25), $facebook_link);
        $contacts[] = $this->verifyAndCreateTeamContact($team->id, substr($twitter_link, 20), $twitter_link);

        return view('team-contact', ['team' => $team, 'contacts' => $contacts]);
    }
}