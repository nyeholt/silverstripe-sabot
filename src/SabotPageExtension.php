<?php

namespace Symbiote\Sabot;


use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\CMS\Model\SiteTreeExtension;
use Symbiote\MultiValueField\Fields\KeyValueField;
use Symbiote\Multisites\Multisites;
use Symbiote\Multisites\Model\Site;
use SilverStripe\SiteConfig\SiteConfig;


/**
 * @author marcus
 */
class SabotPageExtension extends SiteTreeExtension {
    private static $db = array(
        'CustomAccessKeys' => 'MultiValueField',
    );
    
    public function updateCMSFields(FieldList $fields) {
        $this->addKeyField($fields);
    }
    
    public function updateSiteCMSFields(FieldList $fields) {
        $this->addKeyField($fields);
    }
    
    public function addKeyField($fields) {
        $options = KeyValueField::create('CustomAccessKeys', 'Access links');
        $fields->addFieldToTab('Root.Accessibility', $options);
    }
    
    public function customKeys() {
        $keys = ArrayList::create();
        $keysVal = $this->owner->CustomAccessKeys->getValues();
        if ($keysVal && count($keysVal)) {
            foreach ($keysVal as $k => $v) {
                $keys->push(ArrayData::create(array(
                    'Title'     => $v,
                    'Link'      => $k
                )));
            }
        }
        return $keys;
    }
    
    public function PageAccessKeys() {
        $site = null;
        if (class_exists(Symbiote\Multisites\Multisites::class)) {
            $site = Symbiote\Multisites\Multisites::inst()->getCurrentSite();
        } else {
            $site = SiteConfig::get()->first();
        }

        $keys = ArrayList::create();
        if ($site && $site->hasMethod('SiteAccessKeys')) {
            $keys = $site->SiteAccessKeys();
        }
        
        if (!($this->owner instanceof Site)) {
            $pageKeys = $this->owner->customKeys();
            foreach ($pageKeys as $k) {
                $keys->push($k);
            }
        }

        $keys->removeDuplicates('Link');
        
        // TODO add in the page specific ones
        $this->owner->invokeWithExtensions('updatePageAccessKeys', $keys);
        
        return $keys;
    }
}
