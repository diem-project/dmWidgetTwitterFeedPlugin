<?php
require_once('Tweet.class.php');


/**
 * Utility class for use with twitter
 *
 * @author daan
 */
class Util {
  public static $tweet = "http://api.twitter.com/1/statuses/show.json?include_entities=true&id=";
  
  public static function curl_file_contents($url)
  {
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($curl, CURLOPT_URL, $url);
      $contents = curl_exec($curl);
      curl_close($curl);

      if ($contents) {
        return $contents;
      } else {
        return false;
      }
  }
  
  public static function parseAsTweetObject($decoded_json) {
    $tweet = new Tweet();
    
    if(!isset($decoded_json->from_user)) {
      $tweet->user = $decoded_json->user;
      $tweet->entities = $decoded_json->entities;
    } else {
      $tweetsource = json_decode(self::curl_file_contents(self::$tweet.$decoded_json->id_str));
      $tweet->user = $tweetsource->user;
      $tweet->entities = $tweetsource->entities;
    }
    
    $tweet->id = $decoded_json->id_str;
    $tweet->text = $decoded_json->text;
    $tweet->created_at = $decoded_json->created_at;
    
    return $tweet;
  }
}

?>
