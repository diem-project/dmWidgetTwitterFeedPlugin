<?php use_helper('Text'); use_helper('Date');

/*
 * A $tweet is an array containing:
 * - text:        text of the tweet
 * - profile_image_url: image of the tweet's author
 * - created_at:  when the tweet was posted, timestamp
 */

if($show_profile_image || $show_profile_screenname || $show_profile_name || $show_profile_description) {
  
  echo _open('div.twitter_profile');
  
  if($show_profile_image) {
    $profile_image_url = $author->profile_image_url;
    echo _link('http://twitter.com/'.$user)->text(_media($profile_image_url)->set('.twitter_profile_image'));
  }
  
  if($show_profile_screenname) {
    echo _link('https://twitter.com/intent/user?screen_name='.$user)->text($user)->addClass('twitter_profile_screenname');
  }
  
  if($show_profile_name) {
    echo _tag('span.twitter_profile_name', $author->name);
  }
  
  if($show_profile_description) {
    echo _tag('p.twitter_profile_description', $author->description);
  }
}
echo _open('ul');
$oe = 'odd';

foreach($tweets as $tweet)
{

  echo _open('li.' . $oe);

    // render tweet text
    echo _tag('p.tweet_text', $tweet->text);

    // render tweet date
    echo _link('http://twitter.com/'.$user.'/status/'.$tweet->id)->text(_tag('abbr.timeago.tweet_time', array('title' => $tweet->created_at), $tweet->created_at));
    
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