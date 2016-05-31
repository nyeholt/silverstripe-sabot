<?php

/**
 * @author marcus
 */
class SabotControllerExtension extends Extension {
    public function onAfterInit() {
        $site = Multisites::inst()->getCurrentSite();
        
        Requirements::css('sabot/css/sabot.css');
        Requirements::javascript('sabot/javascript/jquery.hotkeys.js');
        Requirements::javascript('sabot/javascript/flying-focus.js');
        Requirements::javascript('sabot/javascript/jquery.scrollTo.js');
        Requirements::javascript('sabot/javascript/jquery.jfontsize-1.0.js');
        Requirements::javascript('sabot/javascript/accessibility-init.js');
        
        if ($site->SabotConfig) {
            $config = $site->SabotConfig->getValues();
            if (count($config)) {
                $script = 'window.sabotConfig = ' . json_encode($config) . ';';
                Requirements::customScript($script, 'sabotconfig');
            }
        }
    }
}
