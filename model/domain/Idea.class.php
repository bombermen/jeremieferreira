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
     * This Idea's Publications list
     * @see loadPublications() to load it
     * @var Publication|Array
     */
    private $_publications = array();

    /**
     * explicit ctor
     * @param $id           Idea's id                    (required)
     * @param $postDate     Idea's postDate              (required)
     * @param $publications Idea's publications          (optional)
     */
     public function Idea($id, $postDate, $publications = null) {

        $this->_id = $id;
        $this->_postDate = $postDate;
        $this->_publications = $publications;
    }

    /**
     * Array ctor
     * @param $tab array
     * @return Idea
     * @throws RequiredFieldException if one or more required field are not set in the array
     * @see Idea() for more information about required fields
     */
    public static function parseArray($tab = array()) {
        if(isset($tab)) {
            //set all temporary attributes to null
            $id = null;
            $postDate = null;
            $publications = null;

            //required field id
            if( isset( $tab['id'] ) ) $id = $tab['id'];
            else throw new RequiredFieldException('id');

            //required field postDate
            if( isset( $tab['postDate'] ) && Utilities::is_integer($tab['postDate']) ) {
                $postDate = new DateTime();
                $postDate->setTimestamp( $tab['postDate'] );
            }

            else throw new RequiredFieldException('postDate');

            return new Idea($id, $postDate, $publications);
        }
    }

    /**
     * Load all the publications for this idea
     */
     public function loadPublications() {
         $this->_publications = DAOFactory::getPublicationDAO()->selectByIdIdea($this->_id);
     }

    /**
     * Update this Idea publications in db
     */
    public function updatePublications() {
        DAOFactory::getIdeaDAO()->updatePublications($this);
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
         return $this->_publications = $publications;
     }

}
