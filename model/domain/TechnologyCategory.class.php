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
     * @var int
     */
    private $_visible;

    /**
     * @var string
     */
    private $_description;

    //references
    /**
     * This TechnologyCategory's Technologys list
     * @see loadTechnologys() to load it
     * @var Technology|Array
     */
    private $_technologys = array();

    /**
     * explicit ctor
     * @param $id           TechnologyCategory's id      (required)
     * @param $name         TechnologyCategory's name    (required)
     * @param $visible      TechnologyCategory's visible (required)
     * @param $description  TechnologyCategory's description (optional)
     * @param $technologys  TechnologyCategory's technologys (optional)
     */
     public function TechnologyCategory($id, $name, $visible, $description = null, $technologys = null) {

        $this->_id = $id;
        $this->_name = $name;
        $this->_visible = $visible;
        $this->_description = $description;
        $this->_technologys = $technologys;
    }

    /**
     * Array ctor
     * @param $tab array
     * @return TechnologyCategory
     * @throws RequiredFieldException if one or more required field are not set in the array
     * @see TechnologyCategory() for more information about required fields
     */
    public static function parseArray($tab = array()) {
        if(isset($tab)) {
            //set all temporary attributes to null
            $id = null;
            $name = null;
            $visible = null;
            $description = null;
            $technologys = null;

            //required field id
            if( isset( $tab['id'] ) ) $id = $tab['id'];
            else throw new RequiredFieldException('id');

            //required field name
            if( isset( $tab['name'] ) ) $name = $tab['name'];
            else throw new RequiredFieldException('name');

            //required field visible
            if( isset( $tab['visible'] ) ) $visible = $tab['visible'];
            else throw new RequiredFieldException('visible');

            //optional field description
            if( isset( $tab['description'] ) ) $description = $tab['description'];

            return new TechnologyCategory($id, $name, $visible, $description, $technologys);
        }
    }

    /**
     * Load all the technologys for this technologyCategory
     */
     public function loadTechnologys() {
         $this->_technologys = DAOFactory::getTechnologyDAO()->selectByIdTechnologyCategory($this->_id);
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
     * @return int
     */
    public function getVisible() {
        return $this->_visible;
    }

    /**
     * @param int
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
     * @return Technology|Array
     */
     public function getTechnologys() {
         return $this->_technologys;
     }

    /**
     * @param Technology|Array
     */
     public function setTechnologys($technologys) {
         return $this->_technologys = $technologys;
     }

}
