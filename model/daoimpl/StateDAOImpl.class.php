<?php

/**
 * Description of StateDAOImpl implements StateDAO
 *
 * @author Jeremie FERREIRA
 */
class StateDAOImpl implements StateDAO {
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
     * Get domain object State by primary key
     * @param int $id primary key
     * @return State
     */
    public function load($id) {
        //initialize the prepared statement if it is not
        if(!isset($this->_loadStatement)) {
            $statement = 'SELECT idState AS id, name FROM State WHERE idState = :id';
            $this->_loadStatement = Connection::getConnection()->prepare($statement);
        }

        //get the first result and return it after closing the cursor
        $this->_loadStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->_loadStatement->execute(array('id' => $id));
        $line = $this->_loadStatement->fetch();
        $this->_loadStatement->closeCursor();
        $result = new State($line);
        return $result;
    }

    /**
     * Get all records from table State
     * @return State|Array
     */
    public function selectAll() {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllStatement)) {
            $statement = 'SELECT idState AS id, name FROM State';
            $this->_selectAllStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as State instances array and return it
        $this->_selectAllStatement->execute();
        $this->_selectAllStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectAllStatement->fetch())
            $result[] = new State($line);
        return $result;
    }

    /**
     * Get all records from table ordered by a column State
     * @param string $column column name
     * @return State|Array
     */
    public function selectAllOrderBy($column) {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllOrderByStatement)) {
            $statement = 'SELECT idState AS id, name FROM State ORDER BY '.$column;
            $this->_selectAllOrderByStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as State instances array and return it
        $this->_selectAllOrderByStatement->execute();
        $this->_selectAllOrderByStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectAllOrderByStatement->fetch())
            $result[] = new State($line);
        return $result;
    }

    /**
     * Delete from State table by primary key
     * @param int $id primary key
     */
    public function delete($id) {
        //initialize the prepared statement if it is not
        if(!isset($this->_deleteStatement)) {
            $statement = 'DELETE FROM State WHERE idState = :id';
            $this->_deleteStatement = Connection::getConnection()->prepare($statement);
        }

        //execute query
        $this->_deleteStatement->execute(array('id' => $id));
    }

    /**
     * Insert record into table State
     * @param State $state primary key
     */
    public function insert($state) {
        //create the statement
        $attributes = $state->getNotNullValues();
        $columns = array();
        $values = array();
        foreach($attributes as $key => $value) {
            $columns[] = $key;
            $values[] = $value;
        }
        $statement = 'INSERT INTO State('.implode(', ', $columns).') VALUES ('.implode(', ', $values).')';
        //prepare and execute the statement
        $query = Connection::getConnection()->prepare($statement);
        $query->execute();
    }

    /**
     * Update record from table State
     * @param State $state primary key
     */
    public function update($state) {
        //create the statement
        $attributes = $state->check();
        $statement = 'UPDATE State SET ';
        foreach($attributes as &$attribute)
            $statement .= $attribute.getName().' = '.$attribute.getType().', ';
        $statement = rtrim($statement, ', ');
        $statement .= ' WHERE idState = '.$state->getId();

        //prepare and execute the statement
        $query = Connection::getConnection()->prepare($statement);
        $query->execute();
    }
}
