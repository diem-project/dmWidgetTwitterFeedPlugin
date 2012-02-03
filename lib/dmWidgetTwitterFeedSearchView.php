<?php

class dmWidgetTwitterFeedSearchView extends dmWidgetPluginView
{
  
  public function configure()
  {
    parent::configure();
    
    $this->addRequiredVar(array('query', 'nb_tweets', 'show_profile_image'));
    $this->addJavascript(array('dmWidgetTwitterFeedPlugin.timeago', 'dmWidgetTwitterFeedPlugin.view', 'http://platform.twitter.com/widgets.js'));
    $this->addStylesheet(array('dmWidgetTwitterFeedPlugin.view'));
  }

  protected function filterViewVars(array $vars = array())
  {
    $vars = parent::filterViewVars($vars);

    $vars['tweets'] = $this->searchTweets($vars['query'], $vars['nb_tweets'], $vars['result_type']);
    
    return $vars;
  }
  
  protected function doRenderForIndex()
  {
    $tweets = array();
    
    foreach($viewVars['tweets'] as $tweet)
    {
      $tweets[] = $tweet->text;
    }
    
    return $viewVars['query'].' '.implode(', ', $tweets);
  }

  protected function searchTweets($query, $nb, $type)
  {
    $tweets = array();
    $twitterfeed = new Search($query, $nb, $type);
    $twitterfeed->retrieve();

    foreach($twitterfeed->getTweets() as $tweet) {
      $tweet->linkify_text();
      $tweets[] = $tweet;
    }

    return $tweets;
  }
  
}