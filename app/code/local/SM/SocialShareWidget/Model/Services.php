<?php
class SM_SocialShareWidget_Model_Services
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'facebook', 'label' => 'Facebook'),
            array('value' => 'google', 'label' => 'Google Plus'),
            array('value' => 'twitter', 'label' => 'Twitter'),
            array('value' => 'pinterest', 'label' => 'Pinterest'),
        );
    }
}