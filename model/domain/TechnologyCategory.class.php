<?php

/**
 * Description of TechnologyCategory
 *
 * @author Jeremie FERREIRA
 */
class TechnologyCategory {
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
    private $_description;

    /**
     * array ctor
     * @param $tab array
     */
    public function TechnologyCategory($tab = array()) {
        if(isset($tab)) {
            if(isset( $tab['id'] )) $this->_id = $tab['id'];
            if(isset( $tab['name'] )) $this->_name = $tab['name'];
            if(isset( $tab['description'] )) $this->_description = $tab['description'];
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
    public function getDescription() {
        return $this->_description;
    }

    /**
     * @param string
     */
    public function setDescription($description) {
        $this->_description = $description;
    }

}
