<?php

/**
 * Description of Tag
 *
 * @author Jeremie FERREIRA
 */
class Tag extends Domain {
    /**
     * @var string
     */
    private $_name;

    //references
    /**
     * Publications list.
     * @see Tag->loadPublication to load it
     * @var int|Array
     */
    private $_publications = array();

    /**
     * array ctor
     * @param $tab array
     */
    public function Tag($tab = array()) {
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
     * Load all the publications for this tag
     */
     public function loadPublications() {
         $this->_publications = DAOFactory::getPublicationDAO()->selectByIdTag;
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
     * @var Publication|Array
     */
     public function getPublications() {
         return $this->_publications;
     }

}
