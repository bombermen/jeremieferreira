<?php

/**
 * Description of IdeaDAOImpl implements IdeaDAO
 *
 * @author Jeremie FERREIRA
 */
class IdeaDAOImpl implements IdeaDAO {
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
     * @param Idea $idea instance to check
     * @return mixed|Array|Array array of couple (attribute_name - attribute_value) for each not null-value
     */
    private static function check($idea) {
        $attributes = array();
        if(!is_null($idea->getpostDate()))
            $attributes[] = array('postDate', 'FROM_UNIXTIME('.$idea->getpostDate()->getTimestamp().')');
            return $attributes;    }

    /**
     * Get domain object Idea by primary key
     * @param int $id primary key
     * @return Idea
     */
    public function load($id) {
        //initialize the prepared statement if it is not
        if(!isset($this->_loadStatement)) {
            $statement = 'SELECT idIdea AS id, UNIX_TIMESTAMP(postDate) AS postDate FROM Idea WHERE idIdea = :id';
            $this->_loadStatement = Connection::getConnection()->prepare($statement);
        }

        //get the first result and return it after closing the cursor
        $this->_loadStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->_loadStatement->execute(array('id' => $id));
        $line = $this->_loadStatement->fetch();
        $this->_loadStatement->closeCursor();
        $result = new Idea($line);
        return $result;
    }

    /**
     * Get all records from table Idea
     * @return Idea|Array
     */
    public function selectAll() {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllStatement)) {
            $statement = 'SELECT idIdea AS id, UNIX_TIMESTAMP(postDate) AS postDate FROM Idea';
            $this->_selectAllStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as Idea instances array and return it
        $this->_selectAllStatement->execute();
        $this->_selectAllStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectAllStatement->fetch())
            $result[] = new Idea($line);
        return $result;
    }

    /**
     * Get all records from table ordered by a column Idea
     * @param string $column column name
     * @return Idea|Array
     */
    public function selectAllOrderBy($column) {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllStatement)) {
            $statement = 'SELECT idIdea AS id, UNIX_TIMESTAMP(postDate) AS postDate FROM Idea ORDER BY '.$column;
            $this->_selectAllStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as Idea instances array and return it
        $this->_selectAllStatement->execute();
        $this->_selectAllStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectAllStatement->fetch())
            $result[] = new Idea($line);
        return $result;
    }

    /**
     * Delete from Idea table by primary key
     * @param int $id primary key
     */
    public function delete($id) {
        //initialize the prepared statement if it is not
        if(!isset($this->_deleteStatement)) {
            $statement = 'DELETE FROM Idea WHERE idIdea = :id';
            $this->_deleteStatement = Connection::getConnection()->prepare($statement);
        }

        //execute query
        $this->_deleteStatement->execute(array('id' => $id));
    }

    /**
     * Insert record into table Idea
     * @param Idea $idea primary key
     */
    public function insert($idea) {
        //create the statement
        $attributes = self::check($idea);
        $statement = 'INSERT INTO Idea(';
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
     * Update record from table Idea
     * @param Idea $idea primary key
     */
    public function update($idea) {
        //create the statement
        $attributes = self::check($idea);
        $statement = 'UPDATE Idea SET ';
        foreach($attributes as &$attribute)
            $statement .= $attribute[0].' = '.$attribute[1].', ';
        $statement = rtrim($statement, ', ');
        $statement .= ' WHERE idIdea = '.$idea->getId();

        //prepare and execute the statement
        $query = Connection::getConnection()->prepare($statement);
        $query->execute();
    }
}
