<?php

/**
 * @author marcus
 */
class SabotConfigExtension extends DataExtension {
    private static $db = array(
        'SabotConfig'       => 'MultiValueField',
    );
    
    public function updateSiteCMSFields(\FieldList $fields) {
        $options = array(
            'skipMenu'  => 'Skip links CSS element selector (#main-skip-block)',
            'useFlyingFocus'    => 'Use flying focus?',
            'menuCombo' => 'Key combination for menu display (ctrl+m)',
            'fontSizeElements'  => "Elements triggered by font resize ('span', 'ul', 'input', 'a', 'td', 'th', 'tr', 'dd', 'dt', 'h1', 'h2', 'h3', 'h4', 'h5')",
            'showScrollup' => 'Should the "scroll up" element be shown?',
            'scrollTop' => 'Element to scroll up to (header)',
            'scrollMessage' => 'Scroll message element (#sabotScrollMessage)',
        );

        $options = KeyValueField::create('SabotConfig', 'Options', $options);
        $fields->addFieldToTab('Root.Accessibility', $options);
    }
    
    public function SiteAccessKeys() {
        $keys = $this->owner->customKeys();
        $this->owner->invokeWithExtensions('updateSiteAccessKeys', $keys);
        return $keys;
    }
}
