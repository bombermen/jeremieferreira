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
     * Persons list.
     * @see Publication->loadPerson to load it
     * @var int|Array
     */
    private $_persons = array();

    /**
     * Ideas list.
     * @var int|Array
     */
    private $_ideas = array();

    /**
     * Technologies list.
     * @see Publication->loadTechnology to load it
     * @var int|Array
     */
    private $_technologies = array();

    /**
     * Tags list.
     * @see Publication->loadTag to load it
     * @var int|Array
     */
    private $_tags = array();

    /**
     * array ctor
     * @param $tab array
     */
    public function Publication($tab = array()) {
        if(isset($tab)) {

            //optional field id
            if(isset( $tab['id'] )) {
                $this->_id = (int)$tab['id'];
            }

            //required field title
            if(isset( $tab['title'] )) {
                $this->_title = (string)$tab['title'];
            } else {
                throw new RequiredFieldException('title');
            }

            //required field shortDescription
            if(isset( $tab['shortDescription'] )) {
                $this->_shortDescription = (string)$tab['shortDescription'];
            } else {
                throw new RequiredFieldException('shortDescription');
            }

            //optional field sourcesUrl
            if(isset( $tab['sourcesUrl'] )) {
                $this->_sourcesUrl = (string)$tab['sourcesUrl'];
            }

            //required field visits
            if(isset( $tab['visits'] )) {
                $this->_visits = (int)$tab['visits'];
            } else {
                throw new RequiredFieldException('visits');
            }
        }
    }

    /**
     * Get all the set values
     * @return Array array of couple (attribute_name => attribute_value) for each not null-value
     */
    public function getNotNullValues() {
        $attributes = array();
        if( isset( $this->_title ) )
            $attributes['title'] = '\''.$this->_title.'\'';
        if( isset( $this->_shortDescription ) )
            $attributes['shortDescription'] = '\''.$this->_shortDescription.'\'';
        if( isset( $this->_sourcesUrl ) )
            $attributes['sourcesUrl'] = '\''.$this->_sourcesUrl.'\'';
        if( isset( $this->_visits ) )
            $attributes['visits'] = $this->_visits;
        return $attributes;
    }

    /**
     * Load all the persons for this publication
     */
     public function loadPersons() {
         $this->_persons = DAOFactory::getPersonDAO()->selectByIdPublication;
     }

    /**
     * Load all the ideas for this publication
     */
     public function loadIdeas() {
         $this->_ideas = DAOFactory::getIdeaDAO()->selectByIdPublication;
     }

    /**
     * Load all the technologies for this publication
     */
     public function loadTechnologies() {
         $this->_technologies = DAOFactory::getTechnologyDAO()->selectByIdPublication;
     }

    /**
     * Load all the tags for this publication
     */
     public function loadTags() {
         $this->_tags = DAOFactory::getTagDAO()->selectByIdPublication;
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
     * @var Category
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
     * @var Publication
     */
     public function getState() {
         return $this->_state;
     }

    /**
     * @param int
     */
     public function setPublication($idPublication) {
         $this->_state = DAOFactory::getPublicationDAO()->load($idPublication);
     }

    /**
     * @var Person|Array
     */
     public function getPersons() {
         return $this->_persons;
     }

    /**
     * @var Idea|Array
     */
     public function getIdeas() {
         return $this->_ideas;
     }

    /**
     * @var Technology|Array
     */
     public function getTechnologies() {
         return $this->_technologies;
     }

    /**
     * @var Tag|Array
     */
     public function getTags() {
         return $this->_tags;
     }

}
