<?php

/**
 * @author marcus
 */
class SabotPageExtension extends SiteTreeExtension {
    public function PageAccessKeys() {
        $site = Multisites::inst()->getCurrentSite();
        $siteKeys = $site->SiteAccessKeys();
        
        // TODO add in the page specific ones
        $this->owner->invokeWithExtensions('updatePageAccessKeys', $siteKeys);
        
        return $siteKeys;
    }
}
