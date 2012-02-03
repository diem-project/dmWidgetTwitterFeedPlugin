<?php

class dmWidgetTwitterFeedPublicTimelineView extends dmWidgetPluginView
{
  
  public function configure()
  {
    parent::configure();
    
    $this->addRequiredVar(array('nb_tweets', 'show_profile_image'));
    $this->addJavascript(array('dmWidgetTwitterFeedPlugin.timeago', 'dmWidgetTwitterFeedPlugin.view', 'http://platform.twitter.com/widgets.js'));
    $this->addStylesheet(array('dmWidgetTwitterFeedPlugin.view'));
  }

  protected function filterViewVars(array $vars = array())
  { 
    $vars['tweets'] = $this->getPublicTweets($vars['nb_tweets']);
    
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
    
    return implode(', ', $tweets);
  }

  protected function getPublicTweets($nb)
  {
    $tweets = array();
    $twitterfeed = new Timeline(null, $nb);
    $twitterfeed->retrieve();

    foreach($twitterfeed->getTweets() as $tweet) {
      $tweet->linkify_text();
      $tweets[] = $tweet;
    }

    return $tweets;
  }
  
}