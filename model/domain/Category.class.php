<?php

/**
 * Description of Category
 *
 * @author Jeremie FERREIRA
 */
class Category {
    /**
     * @var int
     */
    private $_id;

    /**
     * @var string
     */
    private $_name;

    /**
     * @var string
     */
    private $_abstract;

    /**
     * array ctor
     * @param $tab array
     */
    public function Category($tab = array()) {
        if(isset($tab)) {
            if(isset( $tab['id'] )) $this->_id = $tab['id'];
            if(isset( $tab['name'] )) $this->_name = $tab['name'];
            if(isset( $tab['abstract'] )) $this->_abstract = $tab['abstract'];
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

}
