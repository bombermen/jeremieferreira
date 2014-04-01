<?php

/**
 * Description of TechnologyDAOImpl implements TechnologyDAO
 *
 * @author Jeremie FERREIRA
 */
class TechnologyDAOImpl implements TechnologyDAO {
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
     * @param Technology $technology instance to check
     * @return mixed|Array|Array array of couple (attribute_name - attribute_value) for each not null-value
     */
    private static function check($technology) {
        $attributes = array();
        if(!is_null($technology->getname()))
            $attributes[] = array('name', "'".$technology->getname()."'");
        if(!is_null($technology->getcategory()))
            $attributes[] = array('category', "'".$technology->getcategory()."'");
            return $attributes;    }

    /**
     * Get domain object Technology by primary key
     * @param int $id primary key
     * @return Technology
     */
    public function load($id) {
        //initialize the prepared statement if it is not
        if(!isset($this->_loadStatement)) {
            $statement = 'SELECT idTechnology AS id, name, category FROM Technology WHERE idTechnology = :id';
            $this->_loadStatement = Connection::getConnection()->prepare($statement);
        }

        //get the first result and return it after closing the cursor
        $this->_loadStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->_loadStatement->execute(array('id' => $id));
        $line = $this->_loadStatement->fetch();
        $this->_loadStatement->closeCursor();
        $result = new Technology($line);
        return $result;
    }

    /**
     * Get all records from table Technology
     * @return Technology|Array
     */
    public function selectAll() {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllStatement)) {
            $statement = 'SELECT idTechnology AS id, name, category FROM Technology';
            $this->_selectAllStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as Technology instances array and return it
        $this->_selectAllStatement->execute();
        $this->_selectAllStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectAllStatement->fetch())
            $result[] = new Technology($line);
        return $result;
    }

    /**
     * Get all records from table ordered by a column Technology
     * @param string $column column name
     * @return Technology|Array
     */
    public function selectAllOrderBy($column) {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllStatement)) {
            $statement = 'SELECT idTechnology AS id, name, category FROM Technology ORDER BY '.$column;
            $this->_selectAllStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as Technology instances array and return it
        $this->_selectAllStatement->execute();
        $this->_selectAllStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectAllStatement->fetch())
            $result[] = new Technology($line);
        return $result;
    }

    /**
     * Delete from Technology table by primary key
     * @param int $id primary key
     */
    public function delete($id) {
        //initialize the prepared statement if it is not
        if(!isset($this->_deleteStatement)) {
            $statement = 'DELETE FROM Technology WHERE idTechnology = :id';
            $this->_deleteStatement = Connection::getConnection()->prepare($statement);
        }

        //execute query
        $this->_deleteStatement->execute(array('id' => $id));
    }

    /**
     * Insert record into table Technology
     * @param Technology $technology primary key
     */
    public function insert($technology) {
        //create the statement
        $attributes = self::check($technology);
        $statement = 'INSERT INTO Technology(';
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
     * Update record from table Technology
     * @param Technology $technology primary key
     */
    public function update($technology) {
        //create the statement
        $attributes = self::check($technology);
        $statement = 'UPDATE Technology SET ';
        foreach($attributes as &$attribute)
            $statement .= $attribute[0].' = '.$attribute[1].', ';
        $statement = rtrim($statement, ', ');
        $statement .= ' WHERE idTechnology = '.$technology->getId();

        //prepare and execute the statement
        $query = Connection::getConnection()->prepare($statement);
        $query->execute();
    }
}