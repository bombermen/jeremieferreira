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
     * This Person's Publications list
     * @see loadPublications() to load it
     * @var Publication|Array
     */
    private $_publications = array();

    /**
     * explicit ctor
     * @param $id           Person's id                  (required)
     * @param $name         Person's name                (required)
     * @param $surname      Person's surname             (required)
     * @param $birthdate    Person's birthdate           (required)
     * @param $website      Person's website             (optional)
     * @param $email        Person's email               (optional)
     * @param $publications Person's publications        (optional)
     */
     public function Person($id, $name, $surname, $birthdate, $website = null, $email = null, $publications = null) {

        $this->_id = $id;
        $this->_name = $name;
        $this->_surname = $surname;
        $this->_birthdate = $birthdate;
        $this->_website = $website;
        $this->_email = $email;
        $this->_publications = $publications;
    }

    /**
     * Array ctor
     * @param $tab array
     * @return Person
     * @throws RequiredFieldException if one or more required field are not set in the array
     * @see Person() for more information about required fields
     */
    public static function parseArray($tab = array()) {
        if(isset($tab)) {
            //set all temporary attributes to null
            $id = null;
            $name = null;
            $surname = null;
            $birthdate = null;
            $website = null;
            $email = null;
            $publications = null;

            //required field id
            if( isset( $tab['id'] ) ) $id = $tab['id'];
            else throw new RequiredFieldException('id');

            //required field name
            if( isset( $tab['name'] ) ) $name = $tab['name'];
            else throw new RequiredFieldException('name');

            //required field surname
            if( isset( $tab['surname'] ) ) $surname = $tab['surname'];
            else throw new RequiredFieldException('surname');

            //required field birthdate
            if( isset( $tab['birthdate'] ) && Utilities::is_integer($tab['birthdate']) ) {
                $birthdate = new DateTime();
                $birthdate->setTimestamp( $tab['birthdate'] );
            }

            else throw new RequiredFieldException('birthdate');

            //optional field website
            if( isset( $tab['website'] ) ) $website = $tab['website'];

            //optional field email
            if( isset( $tab['email'] ) ) $email = $tab['email'];

            return new Person($id, $name, $surname, $birthdate, $website, $email, $publications);
        }
    }

    /**
     * Load all the publications for this person
     */
     public function loadPublications() {
         $this->_publications = DAOFactory::getPublicationDAO()->selectByIdPerson($this->_id);
     }

    /**
     * Update this Person publications in db
     */
    public function updatePublications() {
        DAOFactory::getPersonDAO()->updatePublications($this);
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
