<?php

class dmWidgetTwitterFeedSearchForm extends dmWidgetPluginForm
{
  protected static
  $types = array(
    'recent' => 'Recent',
    'popular' => 'Popular',
    'mixed' => 'Mixed'
  );
          
  public function configure()
  {
    $this->widgetSchema['query'] = new sfWidgetFormInputText();
    $this->validatorSchema['query'] = new sfValidatorString(array(
      'required' => true,
      'min_length' => 3
    ));

    $this->widgetSchema['nb_tweets'] = new sfWidgetFormInputText();
    $this->validatorSchema['nb_tweets'] = new sfValidatorInteger(array(
      'min' => 0,
      'max' => 200
    ));

    $this->widgetSchema['show_profile_image'] = new sfWidgetFormInputCheckbox();
    $this->validatorSchema['show_profile_image'] = new sfValidatorBoolean();
    $this->widgetSchema->setHelp('show_profile_image', 'Show the author profile image');
    
    $this->widgetSchema['result_type'] = new sfWidgetFormSelect(array(
      'choices' => self::$types
    ));
    $this->validatorSchema['result_type'] = new sfValidatorChoice(array(
      'choices' => array_keys(self::$types)
    ));
    $this->widgetSchema->setHelp('result_type', 'Which public tweets to show: The most recent, the most popular, or both.');

    if(!$this->getDefault('nb_tweets'))
    {
      $this->setDefault('nb_tweets', 5);
    }
    
    if(!$this->getDefault('result_type'))
    {
      $this->setDefault('result_type', 'mixed');
    }
    
    parent::configure();
  }
}