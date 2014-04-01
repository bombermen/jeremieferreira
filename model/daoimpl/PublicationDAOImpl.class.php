<?php

/**
 * Description of PublicationDAOImpl implements PublicationDAO
 *
 * @author Jeremie FERREIRA
 */
class PublicationDAOImpl implements PublicationDAO {
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
     * @param Publication $publication instance to check
     * @return mixed|Array|Array array of couple (attribute_name - attribute_value) for each not null-value
     */
    private static function check($publication) {
        $attributes = array();
        if(!is_null($publication->gettitle()))
            $attributes[] = array('title', "'".$publication->gettitle()."'");
        if(!is_null($publication->getshortDescription()))
            $attributes[] = array('shortDescription', "'".$publication->getshortDescription()."'");
        if(!is_null($publication->getsourcesUrl()))
            $attributes[] = array('sourcesUrl', "'".$publication->getsourcesUrl()."'");
        if(!is_null($publication->getstate()))
            $attributes[] = array('state', "'".$publication->getstate()."'");
        if(!is_null($publication->getcategory()))
            $attributes[] = array('category', "'".$publication->getcategory()."'");
        if(!is_null($publication->getvisits()))
            $attributes[] = array('visits', $publication->getvisits());
            return $attributes;    }

    /**
     * Get domain object Publication by primary key
     * @param int $id primary key
     * @return Publication
     */
    public function load($id) {
        //initialize the prepared statement if it is not
        if(!isset($this->_loadStatement)) {
            $statement = 'SELECT idPublication AS id, title, shortDescription, sourcesUrl, state, category, visits FROM Publication WHERE idPublication = :id';
            $this->_loadStatement = Connection::getConnection()->prepare($statement);
        }

        //get the first result and return it after closing the cursor
        $this->_loadStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->_loadStatement->execute(array('id' => $id));
        $line = $this->_loadStatement->fetch();
        $this->_loadStatement->closeCursor();
        $result = new Publication($line);
        return $result;
    }

    /**
     * Get all records from table Publication
     * @return Publication|Array
     */
    public function selectAll() {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllStatement)) {
            $statement = 'SELECT idPublication AS id, title, shortDescription, sourcesUrl, state, category, visits FROM Publication';
            $this->_selectAllStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as Publication instances array and return it
        $this->_selectAllStatement->execute();
        $this->_selectAllStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectAllStatement->fetch())
            $result[] = new Publication($line);
        return $result;
    }

    /**
     * Get all records from table ordered by a column Publication
     * @param string $column column name
     * @return Publication|Array
     */
    public function selectAllOrderBy($column) {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllStatement)) {
            $statement = 'SELECT idPublication AS id, title, shortDescription, sourcesUrl, state, category, visits FROM Publication ORDER BY '.$column;
            $this->_selectAllStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as Publication instances array and return it
        $this->_selectAllStatement->execute();
        $this->_selectAllStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectAllStatement->fetch())
            $result[] = new Publication($line);
        return $result;
    }

    /**
     * Delete from Publication table by primary key
     * @param int $id primary key
     */
    public function delete($id) {
        //initialize the prepared statement if it is not
        if(!isset($this->_deleteStatement)) {
            $statement = 'DELETE FROM Publication WHERE idPublication = :id';
            $this->_deleteStatement = Connection::getConnection()->prepare($statement);
        }

        //execute query
        $this->_deleteStatement->execute(array('id' => $id));
    }

    /**
     * Insert record into table Publication
     * @param Publication $publication primary key
     */
    public function insert($publication) {
        //create the statement
        $attributes = self::check($publication);
        $statement = 'INSERT INTO Publication(';
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
     * Update record from table Publication
     * @param Publication $publication primary key
     */
    public function update($publication) {
        //create the statement
        $attributes = self::check($publication);
        $statement = 'UPDATE Publication SET ';
        foreach($attributes as &$attribute)
            $statement .= $attribute[0].' = '.$attribute[1].', ';
        $statement = rtrim($statement, ', ');
        $statement .= ' WHERE idPublication = '.$publication->getId();

        //prepare and execute the statement
        $query = Connection::getConnection()->prepare($statement);
        $query->execute();
    }
}
