<?php

/**
 * Description of Utilities
 *
 * @author Jeremie Ferreira
 */
final class Utilities {
    
    /**
     * @param mixed $val value to test
     * @return bool true if $val is an integer
     */
    public static function is_integer($val) {
        return ( is_numeric($val) ) && ( (int)$val == (float)$val );
    }
    
    /**
     * Convert domain array into id array
     * @param Domain[] $domainArray
     * @return int[]
     */
    public static function getIds(array $domainArray) {
        $result = array();
        foreach($domainArray as $domain) {
            $result[] = $domain->getId();
        }
        return $result;
    }
}
