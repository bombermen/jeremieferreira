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
    private $_description;

    /**
     * @var int
     */
    private $_visible;

    //references
    /**
     * This Category's Children list
     * @see loadChildren() to load it
     * @var Category|Array
     */
    private $_children = array();

    /**
     * This Category's Publications list
     * @see loadPublications() to load it
     * @var Publication|Array
     */
    private $_publications = array();

    /**
     * This Category's Parent
     * @see loadParent() to load it
     * @var Category
     */
    private $_parent;

    /**
     * explicit ctor
     * @param $id           Category's id                (required)
     * @param $name         Category's name              (required)
     * @param $visible      Category's visible           (required)
     * @param $description  Category's description       (optional)
     * @param $children     Category's children          (optional)
     * @param $publications Category's publications      (optional)
     * @param $parent       Category's parent            (optional)
     */
     public function Category($id, $name, $visible, $description = null, $children = null, $publications = null, $parent = null) {

        $this->_id = $id;
        $this->_name = $name;
        $this->_description = $description;
        $this->_visible = $visible;
        $this->_children = $children;
        $this->_publications = $publications;
        $this->_parent = $parent;
    }

    /**
     * Array ctor
     * @param $tab array
     * @return Category
     * @throws RequiredFieldException if one or more required field are not set in the array
     * @see Category() for more information about required fields
     */
    public static function parseArray($tab = array()) {
        if(isset($tab)) {
            //set all temporary attributes to null
            $id = null;
            $name = null;
            $visible = null;
            $description = null;
            $children = null;
            $publications = null;
            $parent = null;

            //required field id
            if( isset( $tab['id'] ) ) $id = $tab['id'];
            else throw new RequiredFieldException('id');

            //required field name
            if( isset( $tab['name'] ) ) $name = $tab['name'];
            else throw new RequiredFieldException('name');

            //optional field description
            if( isset( $tab['description'] ) ) $description = $tab['description'];

            //required field visible
            if( isset( $tab['visible'] ) ) $visible = $tab['visible'];
            else throw new RequiredFieldException('visible');

            if( isset( $tab['parent'] ) && Utilities::is_integer($tab['parent']) )
                $parent = DAOFactory::getCategoryDAO()->load($tab['parent']);

            return new Category($id, $name, $visible, $description, $children, $publications, $parent);
        }
    }

    /**
    * Load children
    */
    public function loadChildren() {
        $this->_children = DAOFactory::getCategoryDAO()->loadChildren($this->_id);
    }

    /**
     * Load all the publications for this category
     */
     public function loadPublications() {
         $this->_publications = DAOFactory::getPublicationDAO()->selectByIdCategory($this->_id);
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
     * @return Category
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
     * @return Category|Array
     */
     public function getChildren() {
         return $this->_children;
     }

    /**
     * @param Category|Array
     */
     public function setChildren($children) {
         return $this->_children = $children;
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
