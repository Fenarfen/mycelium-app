<?php

namespace App\Http\Controllers;

use Goutte\Client;
use App\Models\Team;
use Symfony\Component\DomCrawler\Crawler;
use App\Traits\CreateTeamContact;

class ScrapeController extends Controller
{
    use CreateTeamContact;

    public function scrape($id)
    {
        $client = new Client();

        // Gets the website of the company with that id
        $team = Team::find($id); 
        $website = $team->website;

        $crawler = $client->request('GET', $website);

        // WIP: currently looks though every anchor on the html page and selects ones with strings of intrest
        $crawler->filter('a')->each(function (Crawler $node) use (&$facebookUrl, &$twitterUrl, &$instagramUrl) {
            $href = $node->attr('href');
            if (strpos($href, 'facebook.com') !== false || strpos($href, 'fb.com') !== false) {
                $facebookUrl = $href;
            } else if (strpos($href, 'twitter.com') !== false) {
                $twitterUrl = $href;
            } else if (strpos($href, 'instagram.com') !== false) {
                $instagramUrl = $href;
            }
        });

        $contacts = [];

        // Get the handles by taking a substring at the correct length
        // e.g. https://facebook.com/ is removed
        $contacts[] = $this->verifyAndCreateTeamContact($team->id, trim(substr($facebookUrl, 25), '/'), $facebookUrl);
        $contacts[] = $this->verifyAndCreateTeamContact($team->id, trim(substr($twitterUrl, 20), '/'), $twitterUrl);
        $contacts[] = $this->verifyAndCreateTeamContact($team->id, trim(substr($instagramUrl, 26), '/'), $instagramUrl);

        return view('team-contact', ['team' => $team, 'contacts' => $contacts]);
    }


}