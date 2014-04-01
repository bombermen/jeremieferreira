<?php

/**
 * Description of Person
 *
 * @author Jeremie FERREIRA
 */
class Person {
    /**
     * @var int
     */
    private $_id;

    /**
     * @var string
     */
    private $_name;

    /**
     * @var string
     */
    private $_surname;

    /**
     * @var DateTime
     */
    private $_birthdate;

    /**
     * @var string
     */
    private $_website;

    /**
     * @var string
     */
    private $_email;

    /**
     * @var string
     */
    private $_picture;

    /**
     * @var Publication|Array
     */
    private $_publications;

    /**
     * array ctor
     * @param $tab array
     */
    public function Person($tab = array()) {
        if(isset($tab)) {
            if(isset( $tab['id'] )) $this->_id = $tab['id'];
            if(isset( $tab['name'] )) $this->_name = $tab['name'];
            if(isset( $tab['surname'] )) $this->_surname = $tab['surname'];
            if(isset( $tab['birthdate'] )) {
                $this->_birthdate = new DateTime();
                $this->_birthdate->setTimestamp( $tab['birthdate'] );
            }
            if(isset( $tab['website'] )) $this->_website = $tab['website'];
            if(isset( $tab['email'] )) $this->_email = $tab['email'];
            if(isset( $tab['picture'] )) $this->_picture = $tab['picture'];
            if(isset( $tab['publications'] )) $this->_publications = $tab['publications'];
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
    public function getName() {
        return $this->_name;
    }

    /**
     * @param string
     */
    public function setName($name) {
        $this->_name = $name;
    }

    /**
     * @return string
     */
    public function getSurname() {
        return $this->_surname;
    }

    /**
     * @param string
     */
    public function setSurname($surname) {
        $this->_surname = $surname;
    }

    /**
     * @return DateTime
     */
    public function getBirthdate() {
        return $this->_birthdate;
    }

    /**
     * @param DateTime
     */
    public function setBirthdate($birthdate) {
        $this->_birthdate = $birthdate;
    }

    /**
     * @return string
     */
    public function getWebsite() {
        return $this->_website;
    }

    /**
     * @param string
     */
    public function setWebsite($website) {
        $this->_website = $website;
    }

    /**
     * @return string
     */
    public function getEmail() {
        return $this->_email;
    }

    /**
     * @param string
     */
    public function setEmail($email) {
        $this->_email = $email;
    }

    /**
     * @return string
     */
    public function getPicture() {
        return $this->_picture;
    }

    /**
     * @param string
     */
    public function setPicture($picture) {
        $this->_picture = $picture;
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
        $this->_publications = $publications;
    }

}
