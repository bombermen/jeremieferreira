<?php

/**
 * Description of Idea
 *
 * @author Jeremie FERREIRA
 */
class Idea extends Domain {
    /**
     * @var DateTime
     */
    private $_postDate;

    //references
    /**
     * Publications list.
     * @var int|Array
     */
    private $_publications = array();

    /**
     * array ctor
     * @param $tab array
     */
    public function Idea($tab = array()) {
        if(isset($tab)) {

            //optional field id
            if(isset( $tab['id'] )) {
                $this->_id = (int)$tab['id'];
            }

            //required field postDate
            if(isset( $tab['postDate'] )) {
                $this->_postDate = new DateTime();
                $this->_postDate->setTimestamp( $tab['postDate'] );
            } else {
                throw new RequiredFieldException('postDate');
            }
        }
    }

    /**
     * Get all the set values
     * @return Array array of couple (attribute_name => attribute_value) for each not null-value
     */
    public function getNotNullValues() {
        $attributes = array();
        if( isset( $this->_postDate ) )
            $attributes['postDate'] = 'FROM_UNIXTIME('.$this->_postDate->getTimestamp().')';
        return $attributes;
    }

    /**
     * Load all the publications for this idea
     */
     public function loadPublications() {
         $this->_publications = DAOFactory::getPublicationDAO()->selectByIdIdea;
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
     * @var Publication|Array
     */
     public function getPublications() {
         return $this->_publications;
     }

}
