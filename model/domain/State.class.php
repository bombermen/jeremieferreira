<?php

/**
 * Description of State
 *
 * @author Jeremie FERREIRA
 */
class State extends Domain {
    /**
     * @var string
     */
    private $_name;

    //references
    /**
     * array ctor
     * @param $tab array
     */
    public function State($tab = array()) {
        if(isset($tab)) {

            //optional field id
            if(isset( $tab['id'] )) {
                $this->_id = (int)$tab['id'];
            }

            //required field name
            if(isset( $tab['name'] )) {
                $this->_name = (string)$tab['name'];
            } else {
                throw new RequiredFieldException('name');
            }
        }
    }

    /**
     * Get all the set values
     * @return Array array of couple (attribute_name => attribute_value) for each not null-value
     */
    public function getNotNullValues() {
        $attributes = array();
        if( isset( $this->_name ) )
            $attributes['name'] = '\''.$this->_name.'\'';
        return $attributes;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->_name;
    }

    /**
     * @param string
     */
    public function setName($name) {
        $this->_name = $name;
    }

    /**
     * @var State
     */
     public function getPublication() {
         return $this->_publication;
     }

    /**
     * @param int
     */
     public function setState($idState) {
         $this->_publication = DAOFactory::getStateDAO()->load($idState);
     }

}
