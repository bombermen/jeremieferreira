<?php

/**
 * Description of TechnologyCategory
 *
 * @author Jeremie FERREIRA
 */
class TechnologyCategory extends Domain {
    /**
     * @var string
     */
    private $_name;

    /**
     * @var bool
     */
    private $_visible;

    /**
     * @var string
     */
    private $_description;

    //references
    /**
     * Technologys list.
     * @var int|Array
     */
    private $_technologys = array();

    /**
     * array ctor
     * @param $tab array
     */
    public function TechnologyCategory($tab = array()) {
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

            //required field visible
            if(isset( $tab['visible'] )) {
                $this->_visible = (bool)$tab['visible'];
            } else {
                throw new RequiredFieldException('visible');
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
        if( isset( $this->_visible ) )
            $attributes['visible'] = $this->_visible;
        if( isset( $this->_description ) )
            $attributes['description'] = '\''.$this->_description.'\'';
        return $attributes;
    }

    /**
     * Load all the technologys for this technologyCategory
     */
     public function loadTechnologys() {
         $this->_technologys = DAOFactory::getTechnologyDAO()->selectByIdTechnologyCategory;
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
     * @return bool
     */
    public function isVisible() {
        return $this->_visible;
    }

    /**
     * @param bool
     */
    public function setVisible($visible) {
        $this->_visible = $visible;
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
     * @var Technology|Array
     */
     public function getTechnologys() {
         return $this->_technologys;
     }

}
