<?php

namespace Symbiote\Sabot;


use SilverStripe\View\Requirements;
use SilverStripe\Core\Extension;
use SilverStripe\SiteConfig\SiteConfig;


/**
 * @author marcus
 */
class SabotControllerExtension extends Extension {
    public function onAfterInit() {

        if (class_exists(Symbiote\Multisites\Multisites::class)) {
            $site = Symbiote\Multisites\Multisites::inst()->getCurrentSite();
        } else {
            $site = SiteConfig::get()->first();
        }
        
        Requirements::css('symbiote/silverstripe-sabot: sabot/css/sabot.css');
        Requirements::javascript('symbiote/silverstripe-sabot: sabot/javascript/accessibility-init.js');
        
        if ($site && $site->SabotConfig) {
            $config = $site->SabotConfig->getValues();
            if (count($config)) {
                if (isset($config['menuCombo'])) {
                    Requirements::javascript('symbiote/silverstripe-sabot: sabot/javascript/jquery.hotkeys.js');
                }
                
                if (isset($config['fontSizeElements'])) {
                    Requirements::javascript('symbiote/silverstripe-sabot: sabot/javascript/jquery.jfontsize-1.0.js');
                }
                
                if (isset($config['showScrollup'])) {
                    Requirements::javascript('symbiote/silverstripe-sabot: sabot/javascript/jquery.scrollTo.js');
                }
                
                if (isset($config['useFlyingFocus'])) {
                    Requirements::javascript('symbiote/silverstripe-sabot: sabot/javascript/flying-focus.js');
                }
                $script = 'window.sabotConfig = ' . json_encode($config) . ';';
                Requirements::customScript($script, 'sabotconfig');
            }
        }
    }
}
