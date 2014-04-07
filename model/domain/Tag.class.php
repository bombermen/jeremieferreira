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
     * This Tag's Publications list
     * @see loadPublications() to load it
     * @var Publication|Array
     */
    private $_publications = array();

    /**
     * explicit ctor
     * @param $id           Tag's id                     (required)
     * @param $name         Tag's name                   (required)
     * @param $publications Tag's publications           (optional)
     */
     public function Tag($id, $name, $publications = null) {

        $this->_id = $id;
        $this->_name = $name;
        $this->_publications = $publications;
    }

    /**
     * Array ctor
     * @param $tab array
     * @return Tag
     * @throws RequiredFieldException if one or more required field are not set in the array
     * @see Tag() for more information about required fields
     */
    public static function parseArray($tab = array()) {
        if(isset($tab)) {
            //set all temporary attributes to null
            $id = null;
            $name = null;
            $publications = null;

            //required field id
            if( isset( $tab['id'] ) ) $id = $tab['id'];
            else throw new RequiredFieldException('id');

            //required field name
            if( isset( $tab['name'] ) ) $name = $tab['name'];
            else throw new RequiredFieldException('name');

            return new Tag($id, $name, $publications);
        }
    }

    /**
     * Load all the publications for this tag
     */
     public function loadPublications() {
         $this->_publications = DAOFactory::getPublicationDAO()->selectByIdTag($this->_id);
     }

    /**
     * Update this Tag publications in db
     */
    public function updatePublications() {
        DAOFactory::getTagDAO()->updatePublications($this);
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
     * @return Publication|Array
     */
     public function getPublications() {
         return $this->_publications;
     }

    /**
     * @param Publication|Array
     */
     public function setPublications($publications) {
         return $this->_publications = $publications;
     }

}
