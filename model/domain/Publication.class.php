<?php

/**
 * Description of Publication
 *
 * @author Jeremie FERREIRA
 */
class Publication {
    /**
     * @var int
     */
    private $_id;

    /**
     * @var strinh
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
     * @var State
     */
    private $_state;

    /**
     * @var Category
     */
    private $_category;

    /**
     * @var int
     */
    private $_visits;

    /**
     * @var Idea|Array
     */
    private $_ideas;

    /**
     * array ctor
     * @param $tab array
     */
    public function Publication($tab = array()) {
        if(isset($tab)) {
            if(isset( $tab['id'] )) $this->_id = $tab['id'];
            if(isset( $tab['title'] )) $this->_title = $tab['title'];
            if(isset( $tab['shortDescription'] )) $this->_shortDescription = $tab['shortDescription'];
            if(isset( $tab['sourcesUrl'] )) $this->_sourcesUrl = $tab['sourcesUrl'];
            if(isset( $tab['state'] )) $this->_state = $tab['state'];
            if(isset( $tab['category'] )) $this->_category = $tab['category'];
            if(isset( $tab['visits'] )) $this->_visits = $tab['visits'];
            if(isset( $tab['ideas'] )) $this->_ideas = $tab['ideas'];
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
     * @return strinh
     */
    public function getTitle() {
        return $this->_title;
    }

    /**
     * @param strinh
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
     * @return State
     */
    public function getState() {
        return $this->_state;
    }

    /**
     * @param State
     */
    public function setState($state) {
        $this->_state = $state;
    }

    /**
     * @return Category
     */
    public function getCategory() {
        return $this->_category;
    }

    /**
     * @param Category
     */
    public function setCategory($category) {
        $this->_category = $category;
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
     * @return Idea|Array
     */
    public function getIdeas() {
        return $this->_ideas;
    }

    /**
     * @param Idea|Array
     */
    public function setIdeas($ideas) {
        $this->_ideas = $ideas;
    }

}
