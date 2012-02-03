<?php use_helper('Text');

/*
 * A $tweet is an array containing:
 * - from_user:   username of the one who posted the tweet
 * - text:        text of the tweet
 * - profile_image_url: text tweet author's profilem image
 * - created_at:  when the tweet was posted, timestamp
 */

echo _open('ul');
$oe = 'odd';

foreach($tweets as $tweet)
{

  echo _open('li.' . $oe);

    if ($show_profile_image) {
      $profile_image_url = $tweet->user->profile_image_url;
      echo _media($profile_image_url)->set('.tweet_profile_image');
    }
    
    // link to the user page on twitter
    echo _link('https://twitter.com/intent/user?screen_name='.$tweet->user->screen_name)
    ->text($tweet->user->screen_name)
    ->set('.tweet_screen_name');

    // render tweet text
    echo _tag('p.tweet_text', $tweet->text);
    
    // render tweet date
    echo _link('http://twitter.com/'.$tweet->user->screen_name.'/status/'.$tweet->id)->text(_tag('abbr.timeago.tweet_time', array('title' => $tweet->created_at), $tweet->created_at));
    
    echo _open('div.tweet_sprites');
    echo _open('ul');
    
      echo _tag('li', _link('http://twitter.com/intent/tweet?in_reply_to='.$tweet->id)->text('')->addClass('tweet_reply'));
      echo _tag('li', _link('http://twitter.com/intent/retweet?tweet_id='.$tweet->id)->text('')->addClass('tweet_retweet'));
      echo _tag('li', _link('http://twitter.com/intent/favorite?tweet_id='.$tweet->id)->text('')->addClass('tweet_favorite'));
      
    echo _close('ul');
    echo _close('div');
    
  echo _close('li');
  
  $oe = $oe == 'odd' ? 'even' : 'odd' ;

}

echo _close('ul');