<?php

/**
 * @author marcus
 */
class SabotConfigExtension extends DataExtension {
    private static $db = array(
        'SabotConfig'       => 'MultiValueField',
    );
    
    private static $default_sabot_options = array(
        'skipMenu' => '#main-skip-block',
        'useFlyingFocus'    => '1',
        'menuCombo' => 'ctrl+m',
        'fontSizeElements' => 'span,ul,input,a,td,th,tr,dd,dt,h1,h2,h3,h4,h5',
        'showScrollup' => '1',
        'scrollTop' => 'header',
        'scrollMessage' => '#sabotScrollMessage',
    );
    
    public function updateSiteCMSFields(\FieldList $fields) {
        $options = array(
            'skipMenu'  => 'Skip links CSS element selector ',
            'useFlyingFocus'    => 'Use flying focus?',
            'menuCombo' => 'Key combination for menu display ',
            'fontSizeElements'  => "Elements triggered by font resize ",
            'showScrollup' => 'Should the "scroll up" element be shown?',
            'scrollTop' => 'Element to scroll up to ',
            'scrollMessage' => 'Scroll message element ',
        );
        
        $defaults = $this->owner->config()->default_sabot_options;
//        foreach ($options as $opt => $val) {
//            if (isset($defaults[$opt])) {
//                $options[$opt] = $val . ' (' . Convert::raw2htmlatt($defaults[$opt]) . ')';
//            }
//        }

        $options = KeyValueField::create('SabotConfig', 'Options', $options);
        $options->setRightTitle('Enter "-" for default value');
        $fields->addFieldToTab('Root.Accessibility', $options);
    }
    
    public function onBeforeWrite() {
        $defaults = $this->owner->config()->default_sabot_options;
        $setValues = $this->owner->SabotConfig->getValues();
        if (is_array($setValues)) {
            foreach ($setValues as $key => $val) {
                if ($val == '-' && isset($defaults[$key])) {
                    $setValues[$key] = $defaults[$key];
                }
            }
            $this->owner->SabotConfig = $setValues;
        }
    }
    
    public function SiteAccessKeys() {
        $keys = $this->owner->customKeys();
        $this->owner->invokeWithExtensions('updateSiteAccessKeys', $keys);
        return $keys;
    }
}
