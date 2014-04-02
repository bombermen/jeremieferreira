<?php

/**
 * Description of RequiredFieldException
 *
 * @author Jeremie Ferreira
 */
class Domain {
    
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
