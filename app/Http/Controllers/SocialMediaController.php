<?php


namespace App\Http\Controllers;

ini_set("display_errors", 1);

use App\Models\Team;
use App\Models\TeamContact;
use App\Traits\CreateTeamContact;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    public function index()
    {
        return view('social-media', ['response' => $this->TwitterPostStatus()]);
    }

    public function TwitterPostStatus()
    {
        $twitter_test_consumer = getenv('TWITTER_TEST_CONSUMER');
        $twitter_test_consumer_secret = getenv('TWITTER_TEST_CONSUMER_SECRET');
        $twitter_test_access_token = getenv('TWITTER_TEST_ACCESS_TOKEN');
        $twitter_test_access_secret = getenv('TWITTER_TEST_ACCESS_SECRET');

        $oauth = [
            'oauth_consumer_key' => $twitter_test_consumer,
            'oauth_nonce' => time(),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_token' => $twitter_test_access_token,
            'oauth_timestamp' => time(),
            'oauth_version' => '1.0',
        ];

        $url = 'https://api.twitter.com/2/tweets';
        $method = 'POST';

        $baseInfo = $this->buildString($method, $url, $oauth);

        $encodeKey = rawurlencode($twitter_test_consumer_secret) . '&' . rawurlencode($twitter_test_access_secret);
        $oauthSignature = base64_encode(hash_hmac('sha1', $baseInfo, $encodeKey, true));
        $encodedSignature = urlencode($oauthSignature);

        $curl = curl_init();


        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => '{
                "text": "Hello World from mycelium-app4!"
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: OAuth oauth_consumer_key="' . $twitter_test_consumer . '",oauth_token="' . $twitter_test_access_token . '",oauth_signature_method="HMAC-SHA1",oauth_timestamp="' . time() . '",oauth_nonce="' . time() . '",oauth_version="1.0",oauth_signature="' . $encodedSignature . '"',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        echo $response;
        curl_close($curl);

        if (isset($response['data']))
            return "success";
        else if (isset($response['error']))
            return "failure";
        else
            return "Error: no response";
    }

    function buildString($method, $url, $params)
    {
        $headers = [];
        ksort($params);
        foreach ($params as $key => $value) {
            $headers[] = "$key=" . rawurlencode($value);
        }
        return $method . "&" . rawurlencode($url) . '&' . rawurlencode(implode('&', $headers));
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

    public function create(Request $request)
    {

        $this->verifyAndCreateTeamContact(
            $request->input('team_id'),
            $request->input('handle'),
            $request->input('website')
        );
    }
}
