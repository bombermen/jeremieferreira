<?php

/**
 * Description of Domain
 *
 * @author Jeremie Ferreira
 */
abstract class Domain {
    
    /**
     * @var int 
     */
    protected $_id;
    
    public function Domain($id) {
        $this->_id = $id;
    }
    
    /**
     * @return int
     */
    public function getId() {
        return $this->_id;
    }
    
    /**
     * @param int $id
     */
    public function setId($id) {
        $this->_id = $id;
    }
}
