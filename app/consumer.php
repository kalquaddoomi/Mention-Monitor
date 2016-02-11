<?php
/**
 * Created by PhpStorm.
 * User: khaled
 * Date: 2/11/16
 * Time: 10:42 AM
 */

include "keys.php";
require_once('../vendor/fennb/phirehose/lib/Phirehose.php');
require_once('../vendor/fennb/phirehose//lib/OauthPhirehose.php');

/**
 * Example of using Phirehose to display a live filtered stream using track words
 */
class FilterTrackConsumer extends OauthPhirehose
{
    /**
     * Enqueue each status
     *
     * @param string $status
     */
    public function enqueueStatus($status)
    {
        // For demonstrative purposes, write to STDOUT
        
        $data = json_decode($status, true);
        if (is_array($data) && isset($data['user']['screen_name'])) {
            print $data['user']['screen_name'] . ': ' . urldecode($data['text']) . "\n";
        }
    }
}

// The OAuth credentials you received when registering your app at Twitter
define("TWITTER_CONSUMER_KEY", "");
define("TWITTER_CONSUMER_SECRET", "");


// The OAuth data for the twitter account
define("OAUTH_TOKEN", "");
define("OAUTH_SECRET", "");

// Start streaming
$streamConsumer = new FilterTrackConsumer(OAUTH_TOKEN, OAUTH_SECRET, Phirehose::METHOD_FILTER);
$streamConsumer->setTrack(array('endorses sanders', 'endorses bernie', 'endorses bernie sanders', 'endorsed sanders', 'endorsed bernie', 'endorsed bernie sanders'));
$streamConsumer->consume();