<?php

/**
 * Description of PersonDAOImpl implements PersonDAO
 *
 * @author Jeremie FERREIRA
 */
class PersonDAOImpl implements PersonDAO {
    /**
     * @var PDOStatement
     */
    private $_loadStatement;

    /**
     * @var PDOStatement
     */
    private $_selectAllStatement;

    /**
     * @var PDOStatement
     */
    private $_selectAllOrderByStatement;

    /**
     * @var PDOStatement
     */
    private $_deleteStatement;

    /**
     * Check all class attributes
     * Used by insert and update
     * @param Person $person instance to check
     * @return mixed|Array|Array array of couple (attribute_name - attribute_value) for each not null-value
     */
    private static function check($person) {
        $attributes = array();
        if(!is_null($person->getname()))
            $attributes[] = array('name', "'".$person->getname()."'");
        if(!is_null($person->getsurname()))
            $attributes[] = array('surname', "'".$person->getsurname()."'");
        if(!is_null($person->getbirthdate()))
            $attributes[] = array('birthdate', 'FROM_UNIXTIME('.$person->getbirthdate()->getTimestamp().')');
        if(!is_null($person->getwebsite()))
            $attributes[] = array('website', "'".$person->getwebsite()."'");
        if(!is_null($person->getemail()))
            $attributes[] = array('email', "'".$person->getemail()."'");
        if(!is_null($person->getpicture()))
            $attributes[] = array('picture', "'".$person->getpicture()."'");
            return $attributes;    }

    /**
     * Get domain object Person by primary key
     * @param int $id primary key
     * @return Person
     */
    public function load($id) {
        //initialize the prepared statement if it is not
        if(!isset($this->_loadStatement)) {
            $statement = 'SELECT idPerson AS id, name, surname, UNIX_TIMESTAMP(birthdate) AS birthdate, website, email, picture FROM Person WHERE idPerson = :id';
            $this->_loadStatement = Connection::getConnection()->prepare($statement);
        }

        //get the first result and return it after closing the cursor
        $this->_loadStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->_loadStatement->execute(array('id' => $id));
        $line = $this->_loadStatement->fetch();
        $this->_loadStatement->closeCursor();
        $result = new Person($line);
        return $result;
    }

    /**
     * Get all records from table Person
     * @return Person|Array
     */
    public function selectAll() {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllStatement)) {
            $statement = 'SELECT idPerson AS id, name, surname, UNIX_TIMESTAMP(birthdate) AS birthdate, website, email, picture FROM Person';
            $this->_selectAllStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as Person instances array and return it
        $this->_selectAllStatement->execute();
        $this->_selectAllStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectAllStatement->fetch())
            $result[] = new Person($line);
        return $result;
    }

    /**
     * Get all records from table ordered by a column Person
     * @param string $column column name
     * @return Person|Array
     */
    public function selectAllOrderBy($column) {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllStatement)) {
            $statement = 'SELECT idPerson AS id, name, surname, UNIX_TIMESTAMP(birthdate) AS birthdate, website, email, picture FROM Person ORDER BY '.$column;
            $this->_selectAllStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as Person instances array and return it
        $this->_selectAllStatement->execute();
        $this->_selectAllStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectAllStatement->fetch())
            $result[] = new Person($line);
        return $result;
    }

    /**
     * Delete from Person table by primary key
     * @param int $id primary key
     */
    public function delete($id) {
        //initialize the prepared statement if it is not
        if(!isset($this->_deleteStatement)) {
            $statement = 'DELETE FROM Person WHERE idPerson = :id';
            $this->_deleteStatement = Connection::getConnection()->prepare($statement);
        }

        //execute query
        $this->_deleteStatement->execute(array('id' => $id));
    }

    /**
     * Insert record into table Person
     * @param Person $person primary key
     */
    public function insert($person) {
        //create the statement
        $attributes = self::check($person);
        $statement = 'INSERT INTO Person(';
        foreach($attributes as &$attribute)
            $statement .= $attribute[0].', ';
        $statement = rtrim($statement, ', ');
        $statement .= ') VALUES (';
        foreach($attributes as &$attribute)
            $statement .= $attribute[1].', ';
        $statement = rtrim($statement, ', ');
        $statement .= ')';

        //prepare and execute the statement
        $query = Connection::getConnection()->prepare($statement);
        $query->execute();
    }

    /**
     * Update record from table Person
     * @param Person $person primary key
     */
    public function update($person) {
        //create the statement
        $attributes = self::check($person);
        $statement = 'UPDATE Person SET ';
        foreach($attributes as &$attribute)
            $statement .= $attribute[0].' = '.$attribute[1].', ';
        $statement = rtrim($statement, ', ');
        $statement .= ' WHERE idPerson = '.$person->getId();

        //prepare and execute the statement
        $query = Connection::getConnection()->prepare($statement);
        $query->execute();
    }
}
