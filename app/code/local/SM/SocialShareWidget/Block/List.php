<?php
class SM_SocialShareWidget_Block_List extends Mage_Core_Block_Template
    implements Mage_Widget_Block_Interface
{
    /**
     * A model to serialize attributes
     * @var Varien_Object
     */
    protected $_serializer = null;

    /**
     * Initialization
     */
    protected function _construct()
    {
        $this->_serializer = new Varien_Object();
        parent::_construct();
    }

    /**
     * Produce links list rendered as html
     *
     * @return string
     */
    protected function _toHtml()
    {
        $html = '';
        $config = $this->getData('enabled_services');
        if (empty($config)) {
            return $html;
        }
        $services = explode(',', $config);
        $list = array();
        foreach ($services as $service) {
            $item = $this->_generateServiceLink($service);
            if ($item) {
                $list[] = $item;
            }
        }
        $this->assign('list', $list);
        return parent::_toHtml();
    }

    /**
     * Generate link attributes
     *
     * The method returns an array, containing any number of link attributes,
     * All values are optional
     * array(
     *  'href' => '...',
     *  'title' => '...',
     *  '_target' => '...',
     *  'onclick' => '...',
     * )
     *
     * @param string $service
     * @return array
     */
    protected function _generateServiceLink($service)
    {
        /**
         * Page title
         */
        $pageTitle = '';
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $pageTitle = $headBlock->getTitle();
        }

        /**
         * Current URL
         */
        $currentUrl = $this->getUrl('*/*/*', array('_current' => true, '_use_rewrite' => true));

        /**
         * Link HTML
         */
        $attributes = array();
        $icon = '';
        switch ($service) {
            case 'facebook':
                $attributes = array(
                    'href'  => 'https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode($currentUrl) . '&v=1',
                    'title' => 'Share this on Facebook!',
                    'target' => '_blank',
                    'onclick'   => 'window.open(\'https://www.facebook.com/sharer/sharer.php?u='
                        . rawurlencode($currentUrl) . "&v=1', 'facebook', 'toolbar=no,width=700,height=400'); return false;",
                );
                $icon = 'facebook.gif';
                break;
            case 'google':
                $attributes = array(
                    'href'  => 'https://plus.google.com/share?url=' . rawurlencode($currentUrl),
                    'title' => 'Share this on Google+!',
                    'target' => '_blank',
                    'onclick'   => 'window.open(\'https://plus.google.com/share?url='
                        . rawurlencode($currentUrl) . "', 'google', 'toolbar=no,width=700,height=400'); return false;",
                );
                $icon = 'googleplus.gif';
                break;
            case 'twitter':
                $attributes = array(
                    'href'      => 'http://twitter.com/home?status='
                        . rawurlencode('Currently reading ' . $pageTitle . ' at ' . $currentUrl ),
                    'title'     => 'Tweet This!',
                    'target'    => '_blank',
                    'onclick'   => 'window.open(\'http://twitter.com/home?status='
                        . rawurlencode('Currently reading ' . $pageTitle . ' at ' . $currentUrl ) . "', 'twitter', 'toolbar=no,width=700,height=400'); return false;",
                );
                $icon = 'twitter.gif';
                break;
            case 'pinterest':
                $attributes = array(
                    'href'      => 'http://pinterest.com/pin/create/button/?url='
                        . rawurlencode($currentUrl) . '&title=' . rawurlencode('Share' . $pageTitle . 'on Pinterest'),
                    'title'     => 'Pinterest This!',
                    'target'    => '_blank',
                    'onclick'   => 'window.open(\'http://pinterest.com/pin/create/button/?url='
                        . rawurlencode($currentUrl) . '&title=' . rawurlencode('Share' . $pageTitle . 'on Pinterest') . "', 'pinterest', 'toolbar=no,width=700,height=400'); return false;",
                );
                $icon = 'pinterest.gif';
                break;
            default:
                return array();
                break;
        }

        $item = array(
            'text' => $attributes['title'],
            'attributes' => $this->_serializer->setData($attributes)->serialize(),
            'image' => $this->getSkinUrl("images/" . $icon),
        );

        return $item;
    }
}