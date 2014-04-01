<?php

/**
 * Description of Idea
 *
 * @author Jeremie FERREIRA
 */
class Idea {
    /**
     * @var int
     */
    private $_id;

    /**
     * @var DateTime
     */
    private $_postDate;

    /**
     * @var Publication|Array
     */
    private $_publications;

    /**
     * array ctor
     * @param $tab array
     */
    public function Idea($tab = array()) {
        if(isset($tab)) {
            if(isset( $tab['id'] )) $this->_id = $tab['id'];
            if(isset( $tab['postDate'] )) {
                $this->_postDate = new DateTime();
                $this->_postDate->setTimestamp( $tab['postDate'] );
            }
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
     * @return DateTime
     */
    public function getPostDate() {
        return $this->_postDate;
    }

    /**
     * @param DateTime
     */
    public function setPostDate($postDate) {
        $this->_postDate = $postDate;
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
