<?php
class SM_WidgetDemo_Block_Widget extends Mage_Core_Block_Abstract implements Mage_Widget_Block_Interface
{
    protected function _toHtml()
    {
        return '..../Demo widget';
    }
}