<?php

namespace App\Http\Controllers;

class MastodonController extends Controller
{
    function index()
    {
        return view('mastodon', ['response' => $this->PostStatus()]);
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
