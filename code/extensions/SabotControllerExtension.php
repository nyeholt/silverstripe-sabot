<?php

/**
 * @author marcus
 */
class SabotControllerExtension extends Extension {
    public function onAfterInit() {
        $site = Multisites::inst()->getCurrentSite();
        
        Requirements::css('sabot/css/sabot.css');
        
        Requirements::javascript('sabot/javascript/accessibility-init.js');
        
        if ($site->SabotConfig) {
            $config = $site->SabotConfig->getValues();
            if (count($config)) {
                if (isset($config['menuCombo'])) {
                    Requirements::javascript('sabot/javascript/jquery.hotkeys.js');
                }
                
                if (isset($config['fontSizeElements'])) {
                    Requirements::javascript('sabot/javascript/jquery.jfontsize-1.0.js');
                }
                
                if (isset($config['showScrollup'])) {
                    Requirements::javascript('sabot/javascript/jquery.scrollTo.js');
                }
                
                if (isset($config['useFlyingFocus'])) {
                    Requirements::javascript('sabot/javascript/flying-focus.js');
                }
                $script = 'window.sabotConfig = ' . json_encode($config) . ';';
                Requirements::customScript($script, 'sabotconfig');
            }
        }
    }
}
