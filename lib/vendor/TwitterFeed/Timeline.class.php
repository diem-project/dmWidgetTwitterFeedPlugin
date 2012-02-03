<?php
require_once('Tweet.class.php');
require_once('Util.class.php');

/**
 * Get Twitter public timeline or
 * the timeline of a specific user
 *
 * @author daan
 */
class Timeline {
  private $user;
  private $limit;
  private $tweets;
  private $public = false;
  private static $public_timeline = "http://api.twitter.com/1/statuses/public_timeline.json?include_rts=true&include_entities=true&";
  private static $user_timeline = "http://api.twitter.com/1/statuses/user_timeline.json?include_rts=true&include_entities=true&";
  
  public function __construct($user = null, $limit = 5) {
    if($user == null) {
      $this->public = true;
    }
    
    $this->user = $user;
    if($limit > 20) {
      $this->limit = 20;
    } else {
      $this->limit = $limit;
    }
  }
  
  public function getTweets() {
    return $this->tweets;
  }
  
  public function retrieve() {
    
    if($this->public) {
      $data = Util::curl_file_contents(self::$public_timeline."count=".$this->limit);
    } else {
      $data = Util::curl_file_contents(self::$user_timeline."count=".$this->limit."&screen_name=".$this->user);
    }
    
    $tweetobjects = array();
    $results = json_decode($data);
    foreach($results as $result) {
      $tweetobjects[] = Util::parseAsTweetObject($result);
    }
    $this->tweets = $tweetobjects;
  }
  

}

?>
