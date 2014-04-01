<?php

/**
 * Description of Tag
 *
 * @author Jeremie FERREIRA
 */
class Tag {
    /**
     * @var int
     */
    private $_id;

    /**
     * @var string
     */
    private $_name;

    /**
     * @var Publication|Array
     */
    private $_publications;

    /**
     * array ctor
     * @param $tab array
     */
    public function Tag($tab = array()) {
        if(isset($tab)) {
            if(isset( $tab['id'] )) $this->_id = $tab['id'];
            if(isset( $tab['name'] )) $this->_name = $tab['name'];
            if(isset( $tab['publications'] )) $this->_publications = $tab['publications'];
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
     * @return Publication|Array
     */
    public function getPublications() {
        return $this->_publications;
    }

    /**
     * @param Publication|Array
     */
    public function setPublications($publications) {
        $this->_publications = $publications;
    }

}
