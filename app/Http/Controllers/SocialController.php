<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PulkitJalan\Google\Facades\Google;

class SocialController extends Controller
{
    public function getTwitterUserID($username)
    {

        if ($username == '' || $username == null) {
            return ["error" => true, "message" => "No username specified."];
        }
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.twitter.com/2/users/by/username/' . $username . '?expansions=pinned_tweet_id&user.fields=created_at,public_metrics&tweet.fields=created_at,public_metrics',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $headers = [
            'Authorization: Bearer ' . env('TWITTER_BEARER'),
        ];

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public function getYoutubeChannelID($id)
    {
        $youtube = Google::make('YouTube');
        $queryParams = [
            'id' => $id
        ];
        $channel = $youtube->channels->listChannels('id,statistics,snippet', $queryParams);
        return response()->json($channel->items[0]);
    }
}

// auditDetails
// brandingSettings
// contentDetails
// contentOwnerDetails
// id
// localizations
// snippet
// statistics
// status
// topicDetails