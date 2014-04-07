<?php

/**
 * Description of Publication
 *
 * @author Jeremie FERREIRA
 */
class Publication extends Domain {
    /**
     * @var string
     */
    private $_title;

    /**
     * @var string
     */
    private $_shortDescription;

    /**
     * @var string
     */
    private $_sourcesUrl;

    /**
     * @var int
     */
    private $_visits;

    //references
    /**
     * This Publication's Persons list
     * @see loadPersons() to load it
     * @var Person|Array
     */
    private $_persons = array();

    /**
     * This Publication's Ideas list
     * @see loadIdeas() to load it
     * @var Idea|Array
     */
    private $_ideas = array();

    /**
     * This Publication's Technologies list
     * @see loadTechnologies() to load it
     * @var Technology|Array
     */
    private $_technologies = array();

    /**
     * This Publication's Tags list
     * @see loadTags() to load it
     * @var Tag|Array
     */
    private $_tags = array();

    /**
     * This Publication's Category
     * @var Category
     */
    private $_category;

    /**
     * This Publication's State
     * @var State
     */
    private $_state;

    /**
     * explicit ctor
     * @param $id           Publication's id             (required)
     * @param $title        Publication's title          (required)
     * @param $shortDescription Publication's shortDescription (required)
     * @param $visits       Publication's visits         (required)
     * @param $category     Publication's category       (required)
     * @param $state        Publication's state          (required)
     * @param $sourcesUrl   Publication's sourcesUrl     (optional)
     * @param $persons      Publication's persons        (optional)
     * @param $ideas        Publication's ideas          (optional)
     * @param $technologies Publication's technologies   (optional)
     * @param $tags         Publication's tags           (optional)
     */
     public function Publication($id, $title, $shortDescription, $visits, $category, $state, $sourcesUrl = null, $persons = null, $ideas = null, $technologies = null, $tags = null) {

        $this->_id = $id;
        $this->_title = $title;
        $this->_shortDescription = $shortDescription;
        $this->_sourcesUrl = $sourcesUrl;
        $this->_visits = $visits;
        $this->_persons = $persons;
        $this->_ideas = $ideas;
        $this->_technologies = $technologies;
        $this->_tags = $tags;
        $this->_category = $category;
        $this->_state = $state;
    }

    /**
     * Array ctor
     * @param $tab array
     * @return Publication
     * @throws RequiredFieldException if one or more required field are not set in the array
     * @see Publication() for more information about required fields
     */
    public static function parseArray($tab = array()) {
        if(isset($tab)) {
            //set all temporary attributes to null
            $id = null;
            $title = null;
            $shortDescription = null;
            $visits = null;
            $category = null;
            $state = null;
            $sourcesUrl = null;
            $persons = null;
            $ideas = null;
            $technologies = null;
            $tags = null;

            //required field id
            if( isset( $tab['id'] ) ) $id = $tab['id'];
            else throw new RequiredFieldException('id');

            //required field title
            if( isset( $tab['title'] ) ) $title = $tab['title'];
            else throw new RequiredFieldException('title');

            //required field shortDescription
            if( isset( $tab['shortDescription'] ) ) $shortDescription = $tab['shortDescription'];
            else throw new RequiredFieldException('shortDescription');

            //optional field sourcesUrl
            if( isset( $tab['sourcesUrl'] ) ) $sourcesUrl = $tab['sourcesUrl'];

            //required field visits
            if( isset( $tab['visits'] ) ) $visits = $tab['visits'];
            else throw new RequiredFieldException('visits');

            if( isset( $tab['category'] ) && Utilities::is_integer($tab['category']) )
                $category = DAOFactory::getCategoryDAO()->load($tab['category']);
            else throw new RequiredFieldException('category');

            if( isset( $tab['state'] ) && Utilities::is_integer($tab['state']) )
                $state = DAOFactory::getStateDAO()->load($tab['state']);
            else throw new RequiredFieldException('state');

            return new Publication($id, $title, $shortDescription, $visits, $category, $state, $sourcesUrl, $persons, $ideas, $technologies, $tags);
        }
    }

    /**
     * Load all the persons for this publication
     */
     public function loadPersons() {
         $this->_persons = DAOFactory::getPersonDAO()->selectByIdPublication($this->_id);
     }

    /**
     * Load all the ideas for this publication
     */
     public function loadIdeas() {
         $this->_ideas = DAOFactory::getIdeaDAO()->selectByIdPublication($this->_id);
     }

    /**
     * Load all the technologies for this publication
     */
     public function loadTechnologies() {
         $this->_technologies = DAOFactory::getTechnologyDAO()->selectByIdPublication($this->_id);
     }

    /**
     * Load all the tags for this publication
     */
     public function loadTags() {
         $this->_tags = DAOFactory::getTagDAO()->selectByIdPublication($this->_id);
     }

    /**
     * Update this Publication persons in db
     */
    public function updatePersons() {
        DAOFactory::getPublicationDAO()->updatePersons($this);
    }

    /**
     * Update this Publication ideas in db
     */
    public function updateIdeas() {
        DAOFactory::getPublicationDAO()->updateIdeas($this);
    }

    /**
     * Update this Publication technologies in db
     */
    public function updateTechnologies() {
        DAOFactory::getPublicationDAO()->updateTechnologies($this);
    }

    /**
     * Update this Publication tags in db
     */
    public function updateTags() {
        DAOFactory::getPublicationDAO()->updateTags($this);
    }

    /**
     * @return string
     */
    public function getTitle() {
        return $this->_title;
    }

    /**
     * @param string
     */
    public function setTitle($title) {
        $this->_title = $title;
    }

    /**
     * @return string
     */
    public function getShortDescription() {
        return $this->_shortDescription;
    }

    /**
     * @param string
     */
    public function setShortDescription($shortDescription) {
        $this->_shortDescription = $shortDescription;
    }

    /**
     * @return string
     */
    public function getSourcesUrl() {
        return $this->_sourcesUrl;
    }

    /**
     * @param string
     */
    public function setSourcesUrl($sourcesUrl) {
        $this->_sourcesUrl = $sourcesUrl;
    }

    /**
     * @return int
     */
    public function getVisits() {
        return $this->_visits;
    }

    /**
     * @param int
     */
    public function setVisits($visits) {
        $this->_visits = $visits;
    }

    /**
     * @return Category
     */
     public function getCategory() {
         return $this->_category;
     }

    /**
     * @param int
     */
     public function setCategory($idCategory) {
         $this->_category = DAOFactory::getCategoryDAO()->load($idCategory);
     }

    /**
     * @return State
     */
     public function getState() {
         return $this->_state;
     }

    /**
     * @param int
     */
     public function setState($idState) {
         $this->_state = DAOFactory::getStateDAO()->load($idState);
     }

    /**
     * @return Person|Array
     */
     public function getPersons() {
         return $this->_persons;
     }

    /**
     * @param Person|Array
     */
     public function setPersons($persons) {
         return $this->_persons = $persons;
     }

    /**
     * @return Idea|Array
     */
     public function getIdeas() {
         return $this->_ideas;
     }

    /**
     * @param Idea|Array
     */
     public function setIdeas($ideas) {
         return $this->_ideas = $ideas;
     }

    /**
     * @return Technology|Array
     */
     public function getTechnologies() {
         return $this->_technologies;
     }

    /**
     * @param Technology|Array
     */
     public function setTechnologies($technologies) {
         return $this->_technologies = $technologies;
     }

    /**
     * @return Tag|Array
     */
     public function getTags() {
         return $this->_tags;
     }

    /**
     * @param Tag|Array
     */
     public function setTags($tags) {
         return $this->_tags = $tags;
     }

}
