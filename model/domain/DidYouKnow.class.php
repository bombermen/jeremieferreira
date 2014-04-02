<?php

/**
 * Description of DidYouKnow
 *
 * @author Jeremie FERREIRA
 */
class DidYouKnow extends Domain {
    /**
     * @var string
     */
    private $_knowledge;

    //references
    /**
     * array ctor
     * @param $tab array
     */
    public function DidYouKnow($tab = array()) {
        if(isset($tab)) {

            //optional field id
            if(isset( $tab['id'] )) {
                $this->_id = (int)$tab['id'];
            }

            //required field knowledge
            if(isset( $tab['knowledge'] )) {
                $this->_knowledge = (string)$tab['knowledge'];
            } else {
                throw new RequiredFieldException('knowledge');
            }
        }
    }

    /**
     * Get all the set values
     * @return Array array of couple (attribute_name => attribute_value) for each not null-value
     */
    public function getNotNullValues() {
        $attributes = array();
        if( isset( $this->_knowledge ) )
            $attributes['knowledge'] = '\''.$this->_knowledge.'\'';
        return $attributes;
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
