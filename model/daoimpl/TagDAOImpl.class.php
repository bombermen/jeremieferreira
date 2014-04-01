<?php

/**
 * Description of TagDAOImpl implements TagDAO
 *
 * @author Jeremie FERREIRA
 */
class TagDAOImpl implements TagDAO {
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
     * @param Tag $tag instance to check
     * @return mixed|Array|Array array of couple (attribute_name - attribute_value) for each not null-value
     */
    private static function check($tag) {
        $attributes = array();
        if(!is_null($tag->getname()))
            $attributes[] = array('name', "'".$tag->getname()."'");
            return $attributes;    }

    /**
     * Get domain object Tag by primary key
     * @param int $id primary key
     * @return Tag
     */
    public function load($id) {
        //initialize the prepared statement if it is not
        if(!isset($this->_loadStatement)) {
            $statement = 'SELECT idTag AS id, name FROM Tag WHERE idTag = :id';
            $this->_loadStatement = Connection::getConnection()->prepare($statement);
        }

        //get the first result and return it after closing the cursor
        $this->_loadStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->_loadStatement->execute(array('id' => $id));
        $line = $this->_loadStatement->fetch();
        $this->_loadStatement->closeCursor();
        $result = new Tag($line);
        return $result;
    }

    /**
     * Get all records from table Tag
     * @return Tag|Array
     */
    public function selectAll() {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllStatement)) {
            $statement = 'SELECT idTag AS id, name FROM Tag';
            $this->_selectAllStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as Tag instances array and return it
        $this->_selectAllStatement->execute();
        $this->_selectAllStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectAllStatement->fetch())
            $result[] = new Tag($line);
        return $result;
    }

    /**
     * Get all records from table ordered by a column Tag
     * @param string $column column name
     * @return Tag|Array
     */
    public function selectAllOrderBy($column) {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllStatement)) {
            $statement = 'SELECT idTag AS id, name FROM Tag ORDER BY '.$column;
            $this->_selectAllStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as Tag instances array and return it
        $this->_selectAllStatement->execute();
        $this->_selectAllStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectAllStatement->fetch())
            $result[] = new Tag($line);
        return $result;
    }

    /**
     * Delete from Tag table by primary key
     * @param int $id primary key
     */
    public function delete($id) {
        //initialize the prepared statement if it is not
        if(!isset($this->_deleteStatement)) {
            $statement = 'DELETE FROM Tag WHERE idTag = :id';
            $this->_deleteStatement = Connection::getConnection()->prepare($statement);
        }

        //execute query
        $this->_deleteStatement->execute(array('id' => $id));
    }

    /**
     * Insert record into table Tag
     * @param Tag $tag primary key
     */
    public function insert($tag) {
        //create the statement
        $attributes = self::check($tag);
        $statement = 'INSERT INTO Tag(';
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
     * Update record from table Tag
     * @param Tag $tag primary key
     */
    public function update($tag) {
        //create the statement
        $attributes = self::check($tag);
        $statement = 'UPDATE Tag SET ';
        foreach($attributes as &$attribute)
            $statement .= $attribute[0].' = '.$attribute[1].', ';
        $statement = rtrim($statement, ', ');
        $statement .= ' WHERE idTag = '.$tag->getId();

        //prepare and execute the statement
        $query = Connection::getConnection()->prepare($statement);
        $query->execute();
    }
}
