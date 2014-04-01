<?php

/**
 * Description of State
 *
 * @author Jeremie FERREIRA
 */
class State {
    /**
     * @var int
     */
    private $_id;

    /**
     * @var string
     */
    private $_name;

    /**
     * array ctor
     * @param $tab array
     */
    public function State($tab = array()) {
        if(isset($tab)) {
            if(isset( $tab['id'] )) $this->_id = $tab['id'];
            if(isset( $tab['name'] )) $this->_name = $tab['name'];
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

}
