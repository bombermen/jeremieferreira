<?php

/**
 * Description of Person
 *
 * @author Jeremie FERREIRA
 */
class Person extends Domain {
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

    //references
    /**
     * Publications list.
     * @see Person->loadPublication to load it
     * @var int|Array
     */
    private $_publications = array();

    /**
     * array ctor
     * @param $tab array
     */
    public function Person($tab = array()) {
        if(isset($tab)) {

            //optional field id
            if(isset( $tab['id'] )) {
                $this->_id = (int)$tab['id'];
            }

            //required field name
            if(isset( $tab['name'] )) {
                $this->_name = (string)$tab['name'];
            } else {
                throw new RequiredFieldException('name');
            }

            //required field surname
            if(isset( $tab['surname'] )) {
                $this->_surname = (string)$tab['surname'];
            } else {
                throw new RequiredFieldException('surname');
            }

            //required field birthdate
            if(isset( $tab['birthdate'] )) {
                $this->_birthdate = new DateTime();
                $this->_birthdate->setTimestamp( $tab['birthdate'] );
            } else {
                throw new RequiredFieldException('birthdate');
            }

            //optional field website
            if(isset( $tab['website'] )) {
                $this->_website = (string)$tab['website'];
            }

            //optional field email
            if(isset( $tab['email'] )) {
                $this->_email = (string)$tab['email'];
            }
        }
    }

    /**
     * Get all the set values
     * @return Array array of couple (attribute_name => attribute_value) for each not null-value
     */
    public function getNotNullValues() {
        $attributes = array();
        if( isset( $this->_name ) )
            $attributes['name'] = '\''.$this->_name.'\'';
        if( isset( $this->_surname ) )
            $attributes['surname'] = '\''.$this->_surname.'\'';
        if( isset( $this->_birthdate ) )
            $attributes['birthdate'] = 'FROM_UNIXTIME('.$this->_birthdate->getTimestamp().')';
        if( isset( $this->_website ) )
            $attributes['website'] = '\''.$this->_website.'\'';
        if( isset( $this->_email ) )
            $attributes['email'] = '\''.$this->_email.'\'';
        return $attributes;
    }

    /**
     * Load all the publications for this person
     */
     public function loadPublications() {
         $this->_publications = DAOFactory::getPublicationDAO()->selectByIdPerson;
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
     * @var Publication|Array
     */
     public function getPublications() {
         return $this->_publications;
     }

}
