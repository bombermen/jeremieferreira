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
     * This Technology's Publications list
     * @see loadPublications() to load it
     * @var Publication|Array
     */
    private $_publications = array();

    /**
     * This Technology's TechnologyCategory
     * @var TechnologyCategory
     */
    private $_technologyCategory;

    /**
     * explicit ctor
     * @param $id           Technology's id              (required)
     * @param $name         Technology's name            (required)
     * @param $technologyCategory Technology's technologyCategory (required)
     * @param $description  Technology's description     (optional)
     * @param $publications Technology's publications    (optional)
     */
     public function Technology($id, $name, $technologyCategory, $description = null, $publications = null) {

        $this->_id = $id;
        $this->_name = $name;
        $this->_description = $description;
        $this->_publications = $publications;
        $this->_technologyCategory = $technologyCategory;
    }

    /**
     * Array ctor
     * @param $tab array
     * @return Technology
     * @throws RequiredFieldException if one or more required field are not set in the array
     * @see Technology() for more information about required fields
     */
    public static function parseArray($tab = array()) {
        if(isset($tab)) {
            //set all temporary attributes to null
            $id = null;
            $name = null;
            $technologyCategory = null;
            $description = null;
            $publications = null;

            //required field id
            if( isset( $tab['id'] ) ) $id = $tab['id'];
            else throw new RequiredFieldException('id');

            //required field name
            if( isset( $tab['name'] ) ) $name = $tab['name'];
            else throw new RequiredFieldException('name');

            //optional field description
            if( isset( $tab['description'] ) ) $description = $tab['description'];

            if( isset( $tab['technologyCategory'] ) && Utilities::is_integer($tab['technologyCategory']) )
                $technologyCategory = DAOFactory::getTechnologyCategoryDAO()->load($tab['technologyCategory']);
            else throw new RequiredFieldException('technologyCategory');

            return new Technology($id, $name, $technologyCategory, $description, $publications);
        }
    }

    /**
     * Load all the publications for this technology
     */
     public function loadPublications() {
         $this->_publications = DAOFactory::getPublicationDAO()->selectByIdTechnology($this->_id);
     }

    /**
     * Update this Technology publications in db
     */
    public function updatePublications() {
        DAOFactory::getTechnologyDAO()->updatePublications($this);
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
     * @return TechnologyCategory
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
