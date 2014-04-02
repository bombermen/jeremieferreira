<?php

/**
 * Description of Technology
 *
 * @author Jeremie FERREIRA
 */
class Technology extends Domain {
    /**
     * @var string
     */
    private $_name;

    /**
     * @var string
     */
    private $_description;

    //references
    /**
     * Publications list.
     * @see Technology->loadPublication to load it
     * @var int|Array
     */
    private $_publications = array();

    /**
     * array ctor
     * @param $tab array
     */
    public function Technology($tab = array()) {
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

            //optional field description
            if(isset( $tab['description'] )) {
                $this->_description = (string)$tab['description'];
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
        if( isset( $this->_description ) )
            $attributes['description'] = '\''.$this->_description.'\'';
        return $attributes;
    }

    /**
     * Load all the publications for this technology
     */
     public function loadPublications() {
         $this->_publications = DAOFactory::getPublicationDAO()->selectByIdTechnology;
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
     * @return string
     */
    public function getDescription() {
        return $this->_description;
    }

    /**
     * @param string
     */
    public function setDescription($description) {
        $this->_description = $description;
    }

    /**
     * @var TechnologyCategory
     */
     public function getTechnologyCategory() {
         return $this->_technologyCategory;
     }

    /**
     * @param int
     */
     public function setTechnologyCategory($idTechnologyCategory) {
         $this->_technologyCategory = DAOFactory::getTechnologyCategoryDAO()->load($idTechnologyCategory);
     }

    /**
     * @var Publication|Array
     */
     public function getPublications() {
         return $this->_publications;
     }

}
