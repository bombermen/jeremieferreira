<?php

/**
 * Description of DidYouKnow
 *
 * @author Jeremie FERREIRA
 */
class DidYouKnow {
    /**
     * @var int
     */
    private $_id;

    /**
     * @var string
     */
    private $_knowledge;

    /**
     * array ctor
     * @param $tab array
     */
    public function DidYouKnow($tab = array()) {
        if(isset($tab)) {
            if(isset( $tab['id'] )) $this->_id = $tab['id'];
            if(isset( $tab['knowledge'] )) $this->_knowledge = $tab['knowledge'];
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
    public function getKnowledge() {
        return $this->_knowledge;
    }

    /**
     * @param string
     */
    public function setKnowledge($knowledge) {
        $this->_knowledge = $knowledge;
    }

}
