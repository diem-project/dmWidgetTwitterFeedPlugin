<?php

class dmWidgetTwitterFeedTimelineForm extends dmWidgetPluginForm
{
  public function configure()
  {
    $this->widgetSchema['user'] = new sfWidgetFormInputText();
    $this->validatorSchema['user'] = new sfValidatorString(array(
      'required' => true,
      'min_length' => 3
    ));

    $this->widgetSchema['nb_tweets'] = new sfWidgetFormInputText();
    $this->validatorSchema['nb_tweets'] = new sfValidatorInteger(array(
      'min' => 0,
      'max' => 200
    ));

    $this->widgetSchema['show_profile_screenname'] = new sfWidgetFormInputCheckbox();
    $this->validatorSchema['show_profile_screenname'] = new sfValidatorBoolean();
    $this->widgetSchema->setHelp('show_profile_screenname', 'Show the author screen name');
    
    $this->widgetSchema['show_profile_name'] = new sfWidgetFormInputCheckbox();
    $this->validatorSchema['show_profile_name'] = new sfValidatorBoolean();
    $this->widgetSchema->setHelp('show_profile_name', 'Show the author real name');
    
    $this->widgetSchema['show_profile_description'] = new sfWidgetFormInputCheckbox();
    $this->validatorSchema['show_profile_description'] = new sfValidatorBoolean();
    $this->widgetSchema->setHelp('show_profile_description', 'Show the author description');
    
    $this->widgetSchema['show_profile_image'] = new sfWidgetFormInputCheckbox();
    $this->validatorSchema['show_profile_image'] = new sfValidatorBoolean();
    $this->widgetSchema->setHelp('show_profile_image', 'Show the author profile image. Only works when the above is turned on as well');

    if(!$this->getDefault('nb_tweets'))
    {
      $this->setDefault('nb_tweets', 5);
    }
    
    parent::configure();
  }
}