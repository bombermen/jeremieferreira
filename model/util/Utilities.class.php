<?php

/**
 * Description of RequiredFieldException
 *
 * @author Jeremie Ferreira
 */
final class Utilities {
    
    /**
     * Return true if at least one of the item in $domainArray share the same id
     * as $domain
     * @param Domain $domain
     * @param Domain $domainArray
     * @return boolean
     */
    public static function domainInArray($domain, $domainArray) {
        foreach($domainArray as $item) {
            if($item->getId() == $domain->getId()) return true;
        }
        return false;
    }
    
}
