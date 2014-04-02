<?php

/**
 * Description of RequiredFieldException
 *
 * @author Jeremie Ferreira
 */
class RequiredFieldException extends Exception {
    /**
     * @var string 
     */
    private $_class;
    /**
     * @var String 
     */
    private $_fieldName;
    
    private static $_GENERIC_DESCRIPTION = "Field is required";
    
    public function RequiredFieldException($fieldName, $class = null) {
        $this->_class = $class;
        $this->_fieldName = $fieldName;
    }
    
    /**
     * @return string
     */
    public function getDescription() {
        return self::$_GENERIC_DESCRIPTION;
    }
    
    /**
     * @return string
     */
    public function getClass() {
        return $this->_class;
    }
    
    /**
     * @return string
     */
    public function getFieldName() {
        return $this->_fieldName;
    }
}
