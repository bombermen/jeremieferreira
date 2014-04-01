<?php

/**
 * Description of DidYouKnowDAOImpl implements DidYouKnowDAO
 *
 * @author Jeremie FERREIRA
 */
class DidYouKnowDAOImpl implements DidYouKnowDAO {
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
     * @param DidYouKnow $didYouKnow instance to check
     * @return mixed|Array|Array array of couple (attribute_name - attribute_value) for each not null-value
     */
    private static function check($didYouKnow) {
        $attributes = array();
        if(!is_null($didYouKnow->getknowledge()))
            $attributes[] = array('knowledge', "'".$didYouKnow->getknowledge()."'");
            return $attributes;    }

    /**
     * Get domain object DidYouKnow by primary key
     * @param int $id primary key
     * @return DidYouKnow
     */
    public function load($id) {
        //initialize the prepared statement if it is not
        if(!isset($this->_loadStatement)) {
            $statement = 'SELECT idDidYouKnow AS id, knowledge FROM DidYouKnow WHERE idDidYouKnow = :id';
            $this->_loadStatement = Connection::getConnection()->prepare($statement);
        }

        //get the first result and return it after closing the cursor
        $this->_loadStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->_loadStatement->execute(array('id' => $id));
        $line = $this->_loadStatement->fetch();
        $this->_loadStatement->closeCursor();
        $result = new DidYouKnow($line);
        return $result;
    }

    /**
     * Get all records from table DidYouKnow
     * @return DidYouKnow|Array
     */
    public function selectAll() {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllStatement)) {
            $statement = 'SELECT idDidYouKnow AS id, knowledge FROM DidYouKnow';
            $this->_selectAllStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as DidYouKnow instances array and return it
        $this->_selectAllStatement->execute();
        $this->_selectAllStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectAllStatement->fetch())
            $result[] = new DidYouKnow($line);
        return $result;
    }

    /**
     * Get all records from table ordered by a column DidYouKnow
     * @param string $column column name
     * @return DidYouKnow|Array
     */
    public function selectAllOrderBy($column) {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllStatement)) {
            $statement = 'SELECT idDidYouKnow AS id, knowledge FROM DidYouKnow ORDER BY '.$column;
            $this->_selectAllStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as DidYouKnow instances array and return it
        $this->_selectAllStatement->execute();
        $this->_selectAllStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectAllStatement->fetch())
            $result[] = new DidYouKnow($line);
        return $result;
    }

    /**
     * Delete from DidYouKnow table by primary key
     * @param int $id primary key
     */
    public function delete($id) {
        //initialize the prepared statement if it is not
        if(!isset($this->_deleteStatement)) {
            $statement = 'DELETE FROM DidYouKnow WHERE idDidYouKnow = :id';
            $this->_deleteStatement = Connection::getConnection()->prepare($statement);
        }

        //execute query
        $this->_deleteStatement->execute(array('id' => $id));
    }

    /**
     * Insert record into table DidYouKnow
     * @param DidYouKnow $didYouKnow primary key
     */
    public function insert($didYouKnow) {
        //create the statement
        $attributes = self::check($didYouKnow);
        $statement = 'INSERT INTO DidYouKnow(';
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
     * Update record from table DidYouKnow
     * @param DidYouKnow $didYouKnow primary key
     */
    public function update($didYouKnow) {
        //create the statement
        $attributes = self::check($didYouKnow);
        $statement = 'UPDATE DidYouKnow SET ';
        foreach($attributes as &$attribute)
            $statement .= $attribute[0].' = '.$attribute[1].', ';
        $statement = rtrim($statement, ', ');
        $statement .= ' WHERE idDidYouKnow = '.$didYouKnow->getId();

        //prepare and execute the statement
        $query = Connection::getConnection()->prepare($statement);
        $query->execute();
    }
}
