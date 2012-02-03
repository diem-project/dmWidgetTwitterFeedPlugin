<?php

class dmWidgetTwitterFeedPublicTimelineForm extends dmWidgetPluginForm
{
  public function configure()
  {
    $this->widgetSchema['nb_tweets'] = new sfWidgetFormInputText();
    $this->validatorSchema['nb_tweets'] = new sfValidatorInteger(array(
      'min' => 0,
      'max' => 200
    ));

    $this->widgetSchema['show_profile_image'] = new sfWidgetFormInputCheckbox();
    $this->validatorSchema['show_profile_image'] = new sfValidatorBoolean();
    $this->widgetSchema->setHelp('show_profile_image', 'Show the author profile image');

    if(!$this->getDefault('nb_tweets'))
    {
      $this->setDefault('nb_tweets', 5);
    }
    
    parent::configure();
  }
}