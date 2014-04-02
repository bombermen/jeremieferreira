<?php

/**
 * Description of Category
 *
 * @author Jeremie FERREIRA
 */
class Category extends Domain {
    /**
     * @var string
     */
    private $_name;

    /**
     * @var string
     */
    private $_abstract;

    //references
    /**
     * Children list.
     * @var int|Array
     */
    private $_children = array();

    /**
     * Publications list.
     * @var int|Array
     */
    private $_publications = array();

    /**
     * array ctor
     * @param $tab array
     */
    public function Category($tab = array()) {
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

            //required field abstract
            if(isset( $tab['abstract'] )) {
                $this->_abstract = (string)$tab['abstract'];
            } else {
                throw new RequiredFieldException('abstract');
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
        if( isset( $this->_abstract ) )
            $attributes['abstract'] = '\''.$this->_abstract.'\'';
        return $attributes;
    }

    /**
     * Load all the children for this category
     */
     public function loadChildren() {
         $this->_children = DAOFactory::getCategoryDAO()->selectByIdCategory;
     }

    /**
     * Load all the publications for this category
     */
     public function loadPublications() {
         $this->_publications = DAOFactory::getPublicationDAO()->selectByIdCategory;
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
    public function getAbstract() {
        return $this->_abstract;
    }

    /**
     * @param string
     */
    public function setAbstract($abstract) {
        $this->_abstract = $abstract;
    }

    /**
     * @var Category
     */
     public function getParent() {
         return $this->_parent;
     }

    /**
     * @param int
     */
     public function setCategory($idCategory) {
         $this->_parent = DAOFactory::getCategoryDAO()->load($idCategory);
     }

    /**
     * @var Category|Array
     */
     public function getChildren() {
         return $this->_children;
     }

    /**
     * @var Publication|Array
     */
     public function getPublications() {
         return $this->_publications;
     }

}
