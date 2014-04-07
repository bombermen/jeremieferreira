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

    /**
     * explicit ctor
     * @param $id           DidYouKnow's id              (required)
     * @param $knowledge    DidYouKnow's knowledge       (required)
     */
     public function DidYouKnow($id, $knowledge) {

        $this->_id = $id;
        $this->_knowledge = $knowledge;
    }

    /**
     * Array ctor
     * @param $tab array
     * @return DidYouKnow
     * @throws RequiredFieldException if one or more required field are not set in the array
     * @see DidYouKnow() for more information about required fields
     */
    public static function parseArray($tab = array()) {
        if(isset($tab)) {
            //set all temporary attributes to null
            $id = null;
            $knowledge = null;

            //required field id
            if( isset( $tab['id'] ) ) $id = $tab['id'];
            else throw new RequiredFieldException('id');

            //required field knowledge
            if( isset( $tab['knowledge'] ) ) $knowledge = $tab['knowledge'];
            else throw new RequiredFieldException('knowledge');

            return new DidYouKnow($id, $knowledge);
        }
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
