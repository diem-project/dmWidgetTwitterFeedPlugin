<?php

/**
 * Represents one Tweet
 *
 * @author daan
 */
class Tweet {

  public $user;
  public $entities;
  public $text;
  public $created_at;
  public $id;

  public function linkify_text() {
    
    if (!empty($this->entities->urls) || !empty($this->entities->hashtags) || !empty($this->entities->user_mentions)) {
      foreach ($this->entities->urls as $url) {
        if(!isset($url->display_url)) {
          $find = $url->url;
          $replace = '<a href="' . $find . '">' . $find . '</a>';
        } else {
          $find = $url->url;
          $replace = '<a href="' . $url->expanded_url . '">' . $url->display_url . '</a>';
        }
        $this->text = str_replace($find, $replace, $this->text);
        
      }

      foreach ($this->entities->hashtags as $hashtag) {
        $find = '#' . $hashtag->text;
        $replace = '<a href="http://twitter.com/#!/search/%23' . $hashtag->text . '">' . $find . '</a>';
        $this->text = str_replace($find, $replace, $this->text);
      }

      foreach ($this->entities->user_mentions as $user_mention) {
        $find = "@" . $user_mention->screen_name;
        $replace = '<a href="https://twitter.com/intent/user?screen_name=' . $user_mention->screen_name . '">' . $find . '</a>';
        $this->text = str_ireplace($find, $replace, $this->text);
      }
    }
  }

}

?>
