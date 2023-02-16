<?php

namespace App\Http\Controllers;

use Goutte\Client;
use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\TeamContact;
use Symfony\Component\DomCrawler\Crawler;

class ScrapeController extends Controller
{
    public function scrape()
    {
        $client = new Client();
        // For now get all teams in the database and look through those websites
        $teams = Team::all(); 

        foreach ($teams as $team) {
            $website = $team->website;

            $crawler = $client->request('GET', $website);

            $contacts = [];
            
            // Filter for facebook link
            $facebook_link = $crawler->filter('a[title="Facebook"]')->last()->attr('href');

            array_push($contacts, TeamContact::create([
                    'team_id' => $team->id,
                    'handle' => substr($facebook_link, 25),
                    'website' => $facebook_link,
                ]));
            
            $twitter_link = $crawler->filter('a[title="Twitter"]')->last()->attr('href');

            array_push($contacts, TeamContact::create([
                    'team_id' => $team->id,
                    'handle' => substr($twitter_link, 20),
                    'website' => $twitter_link,
                ]));
        }

        return view('scrape', ['contacts' => $contacts]);
    }
}