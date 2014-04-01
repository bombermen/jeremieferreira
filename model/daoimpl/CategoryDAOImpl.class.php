<?php

/**
 * Description of CategoryDAOImpl implements CategoryDAO
 *
 * @author Jeremie FERREIRA
 */
class CategoryDAOImpl implements CategoryDAO {
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
     * @param Category $category instance to check
     * @return mixed|Array|Array array of couple (attribute_name - attribute_value) for each not null-value
     */
    private static function check($category) {
        $attributes = array();
        if(!is_null($category->getname()))
            $attributes[] = array('name', "'".$category->getname()."'");
        if(!is_null($category->getabstract()))
            $attributes[] = array('abstract', "'".$category->getabstract()."'");
            return $attributes;    }

    /**
     * Get domain object Category by primary key
     * @param int $id primary key
     * @return Category
     */
    public function load($id) {
        //initialize the prepared statement if it is not
        if(!isset($this->_loadStatement)) {
            $statement = 'SELECT idCategory AS id, name, abstract FROM Category WHERE idCategory = :id';
            $this->_loadStatement = Connection::getConnection()->prepare($statement);
        }

        //get the first result and return it after closing the cursor
        $this->_loadStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->_loadStatement->execute(array('id' => $id));
        $line = $this->_loadStatement->fetch();
        $this->_loadStatement->closeCursor();
        $result = new Category($line);
        return $result;
    }

    /**
     * Get all records from table Category
     * @return Category|Array
     */
    public function selectAll() {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllStatement)) {
            $statement = 'SELECT idCategory AS id, name, abstract FROM Category';
            $this->_selectAllStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as Category instances array and return it
        $this->_selectAllStatement->execute();
        $this->_selectAllStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectAllStatement->fetch())
            $result[] = new Category($line);
        return $result;
    }

    /**
     * Get all records from table ordered by a column Category
     * @param string $column column name
     * @return Category|Array
     */
    public function selectAllOrderBy($column) {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllStatement)) {
            $statement = 'SELECT idCategory AS id, name, abstract FROM Category ORDER BY '.$column;
            $this->_selectAllStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as Category instances array and return it
        $this->_selectAllStatement->execute();
        $this->_selectAllStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectAllStatement->fetch())
            $result[] = new Category($line);
        return $result;
    }

    /**
     * Delete from Category table by primary key
     * @param int $id primary key
     */
    public function delete($id) {
        //initialize the prepared statement if it is not
        if(!isset($this->_deleteStatement)) {
            $statement = 'DELETE FROM Category WHERE idCategory = :id';
            $this->_deleteStatement = Connection::getConnection()->prepare($statement);
        }

        //execute query
        $this->_deleteStatement->execute(array('id' => $id));
    }

    /**
     * Insert record into table Category
     * @param Category $category primary key
     */
    public function insert($category) {
        //create the statement
        $attributes = self::check($category);
        $statement = 'INSERT INTO Category(';
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
     * Update record from table Category
     * @param Category $category primary key
     */
    public function update($category) {
        //create the statement
        $attributes = self::check($category);
        $statement = 'UPDATE Category SET ';
        foreach($attributes as &$attribute)
            $statement .= $attribute[0].' = '.$attribute[1].', ';
        $statement = rtrim($statement, ', ');
        $statement .= ' WHERE idCategory = '.$category->getId();

        //prepare and execute the statement
        $query = Connection::getConnection()->prepare($statement);
        $query->execute();
    }
}
