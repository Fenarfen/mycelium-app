<?php

namespace App\Http\Controllers;

use App\Model\SocialMedia;

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
}
