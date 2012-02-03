<?php

class dmWidgetTwitterFeedTimelineView extends dmWidgetPluginView
{
  
  public function configure()
  {
    parent::configure();
    
    $this->addRequiredVar(array('user', 'nb_tweets', 'show_profile_screenname', 'show_profile_name', 'show_profile_description', 'show_profile_image'));
    $this->addJavascript(array('dmWidgetTwitterFeedPlugin.timeago', 'dmWidgetTwitterFeedPlugin.view', 'http://platform.twitter.com/widgets.js'));
    $this->addStylesheet(array('dmWidgetTwitterFeedPlugin.view'));
  }

  protected function filterViewVars(array $vars = array())
  {
    $vars = parent::filterViewVars($vars);

    $vars['tweets'] = $this->getUserTweets($vars['user'], $vars['nb_tweets']);
    
    $author = Util::curl_file_contents('http://api.twitter.com/1/users/show.json?screen_name='.$vars['user']);
    $vars['author'] = json_decode($author);
    
    return $vars;
  }
  
  protected function doRenderForIndex()
  {
    $tweets = array();

    $viewVars = $this->getViewVars();
    
    foreach($viewVars['tweets'] as $tweet)
    {
      $tweets[] = $tweet->text;
    }
    
    return $viewVars['user'].' '.implode(', ', $tweets);
  }

  protected function getUserTweets($user, $nb)
  {
    $tweets = array();
    $twitterfeed = new Timeline($user, $nb);

    $twitterfeed->retrieve();

    foreach($twitterfeed->getTweets() as $tweet) {
      $tweet->linkify_text();
      $tweets[] = $tweet;
    }
    
    $tweets = $this->context->getEventDispatcher()->filter(
        new sfEvent($this, 'dm.widget_twitter_feed_timeline.tweets', array('user' => $user)),
        $tweets
      )->getReturnValue();

    return $tweets;
  }
  
}