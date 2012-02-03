<?php
require_once('Tweet.class.php');
require_once('Util.class.php');

/**
 * Perform a search on twitter
 * through the search API
 *
 * @author daan
 */
class Search {
  private $query;
  private $limit;
  private $tweets;
  private $result_type;
  private static $search = "http://search.twitter.com/search.json?q=";
  
  public function __construct($query, $limit = 5, $result_type = "mixed") {
    
    $this->query = $query;
    $this->result_type = $result_type;
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
    
    $data = Util::curl_file_contents(self::$search.$this->query."&count=".$this->limit."&result_type=".$this->result_type);
    
    $tweetobjects = array();
    $results = json_decode($data);
    $results = $results->results;
    foreach($results as $result) {
      $tweetobjects[] = Util::parseAsTweetObject($result);
    }
    $this->tweets = $tweetobjects;
  }
  

}

?>
