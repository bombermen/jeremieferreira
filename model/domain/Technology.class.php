<?php

/**
 * Description of Technology
 *
 * @author Jeremie FERREIRA
 */
class Technology {
    /**
     * @var int
     */
    private $_id;

    /**
     * @var string
     */
    private $_name;

    /**
     * @var TechnologyCategory
     */
    private $_category;

    /**
     * array ctor
     * @param $tab array
     */
    public function Technology($tab = array()) {
        if(isset($tab)) {
            if(isset( $tab['id'] )) $this->_id = $tab['id'];
            if(isset( $tab['name'] )) $this->_name = $tab['name'];
            if(isset( $tab['category'] )) $this->_category = $tab['category'];
        }
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * @param int
     */
    public function setId($id) {
        $this->_id = $id;
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
     * @return TechnologyCategory
     */
    public function getCategory() {
        return $this->_category;
    }

    /**
     * @param TechnologyCategory
     */
    public function setCategory($category) {
        $this->_category = $category;
    }

}
