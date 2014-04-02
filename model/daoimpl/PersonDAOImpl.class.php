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

    /*
     * @var PDOStatement
     */
    private $_selectByIdPublicationStatement;

    /*
     * @var PDOStatement
     */
    private $_deletePersonPublicationsStatement;

    /*
     * @var PDOStatement
     */
    private $_insertPersonPublicationsStatement;

    /**
     * Get domain object Person by primary key
     * @param int $id primary key
     * @return Person
     */
    public function load($id) {
        //initialize the prepared statement if it is not
        if(!isset($this->_loadStatement)) {
            $statement = 'SELECT idPerson AS id, name, surname, UNIX_TIMESTAMP(birthdate) AS birthdate, website, email FROM Person WHERE idPerson = :id';
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
     * Select all Person records refering to Publication
     * @return Person|Array
     */
    public function selectByIdPublication($idPublication) {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllStatement)) {
            $statement = 'SELECT idPerson AS id, name, surname, UNIX_TIMESTAMP(birthdate) AS birthdate, website, email FROM Person NATURAL JOIN Publication WHERE idPublication = :idPublication';
            $this->_selectByIdPublicationStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as Person instances array and return it
        $this->_selectByIdPublicationStatement->execute(array('idPublication' => $idPublication));
        $this->_selectByIdPublicationStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectByIdPublicationStatement->fetch())
            $result[] = new Person($line);
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
            $statement = 'SELECT idPerson AS id, name, surname, UNIX_TIMESTAMP(birthdate) AS birthdate, website, email FROM Person';
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
        if(!isset($this->_selectAllOrderByStatement)) {
            $statement = 'SELECT idPerson AS id, name, surname, UNIX_TIMESTAMP(birthdate) AS birthdate, website, email FROM Person ORDER BY '.$column;
            $this->_selectAllOrderByStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as Person instances array and return it
        $this->_selectAllOrderByStatement->execute();
        $this->_selectAllOrderByStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectAllOrderByStatement->fetch())
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
        $attributes = $person->getNotNullValues();
        $columns = array();
        $values = array();
        foreach($attributes as $key => $value) {
            $columns[] = $key;
            $values[] = $value;
        }
        try{
        $statement = 'INSERT INTO Person('.implode(', ', $columns).') VALUES ('.implode(', ', $values).')';
        //prepare and execute the statement
        $query = Connection::getConnection()->prepare($statement);
        $query->execute();
        }catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Update record from table Person
     * @param Person $person primary key
     */
    public function update($person) {
        //create the statement
        $attributes = $person->check();
        $statement = 'UPDATE Person SET ';
        foreach($attributes as &$attribute)
            $statement .= $attribute.getName().' = '.$attribute.getType().', ';
        $statement = rtrim($statement, ', ');
        $statement .= ' WHERE idPerson = '.$person->getId();

        //prepare and execute the statement
        $query = Connection::getConnection()->prepare($statement);
        $query->execute();
    }
    /**
    * Update all the records of publications for the selected person
    * @param Person selected + person
    */
    public function updatePublications($person) {
        //get all the existing records for this person
        $existing = Domain::domainArrayAsIdArray( selectByIdPublication($person->getId()) );
        $target = Domain::domainArrayAsIdArray( $person->getPublications);

        //get all records to add as a string : '(idPerson, idPublication), (idPerson, idPublication), ...)'
        $toAdd = array_diff($target, $existing);
        foreach($toAdd as &$item) {
            $item = implode(', ', array($person->getId(), $item));
        }
        $toAdd = '('.implode('), (', $toAdd).')';

        //prepare statements if not set
        if( !isset($this->_deletePersonPublicationStatement) ) {
            $cnx = Connection::getConnection();

            //delete statement
            $statement = 'DELETE * FROM Person_collaboratesTo_Publication WHERE idPerson = :idPerson AND idPublication NOT IN (:target)';
            $this->_deletePersonPublicationsStatement = $cnx->prepareStatement($statement);

            //delete statement
            $statement = 'INSERT INTO Person_collaboratesTo_Publication (idPerson, idPublication) VALUES :insert';
            $this->_insertPersonPublicationsStatement = $cnx->prepareStatement($statement);
        }

        $this->_deletePersonPublicationsStatement->execute( array('target' => implode(', ', $target)) );
        $this->_insertPersonPublicationsStatement->execute( array('target' => implode(', ', $toAdd)) );
    }
}
