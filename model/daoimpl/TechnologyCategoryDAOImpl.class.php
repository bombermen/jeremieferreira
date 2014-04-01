<?php

/**
 * Description of TechnologyCategoryDAOImpl implements TechnologyCategoryDAO
 *
 * @author Jeremie FERREIRA
 */
class TechnologyCategoryDAOImpl implements TechnologyCategoryDAO {
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
     * @param TechnologyCategory $technologyCategory instance to check
     * @return mixed|Array|Array array of couple (attribute_name - attribute_value) for each not null-value
     */
    private static function check($technologyCategory) {
        $attributes = array();
        if(!is_null($technologyCategory->getname()))
            $attributes[] = array('name', "'".$technologyCategory->getname()."'");
        if(!is_null($technologyCategory->getdescription()))
            $attributes[] = array('description', "'".$technologyCategory->getdescription()."'");
            return $attributes;    }

    /**
     * Get domain object TechnologyCategory by primary key
     * @param int $id primary key
     * @return TechnologyCategory
     */
    public function load($id) {
        //initialize the prepared statement if it is not
        if(!isset($this->_loadStatement)) {
            $statement = 'SELECT idTechnologyCategory AS id, name, description FROM TechnologyCategory WHERE idTechnologyCategory = :id';
            $this->_loadStatement = Connection::getConnection()->prepare($statement);
        }

        //get the first result and return it after closing the cursor
        $this->_loadStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->_loadStatement->execute(array('id' => $id));
        $line = $this->_loadStatement->fetch();
        $this->_loadStatement->closeCursor();
        $result = new TechnologyCategory($line);
        return $result;
    }

    /**
     * Get all records from table TechnologyCategory
     * @return TechnologyCategory|Array
     */
    public function selectAll() {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllStatement)) {
            $statement = 'SELECT idTechnologyCategory AS id, name, description FROM TechnologyCategory';
            $this->_selectAllStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as TechnologyCategory instances array and return it
        $this->_selectAllStatement->execute();
        $this->_selectAllStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectAllStatement->fetch())
            $result[] = new TechnologyCategory($line);
        return $result;
    }

    /**
     * Get all records from table ordered by a column TechnologyCategory
     * @param string $column column name
     * @return TechnologyCategory|Array
     */
    public function selectAllOrderBy($column) {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllStatement)) {
            $statement = 'SELECT idTechnologyCategory AS id, name, description FROM TechnologyCategory ORDER BY '.$column;
            $this->_selectAllStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as TechnologyCategory instances array and return it
        $this->_selectAllStatement->execute();
        $this->_selectAllStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectAllStatement->fetch())
            $result[] = new TechnologyCategory($line);
        return $result;
    }

    /**
     * Delete from TechnologyCategory table by primary key
     * @param int $id primary key
     */
    public function delete($id) {
        //initialize the prepared statement if it is not
        if(!isset($this->_deleteStatement)) {
            $statement = 'DELETE FROM TechnologyCategory WHERE idTechnologyCategory = :id';
            $this->_deleteStatement = Connection::getConnection()->prepare($statement);
        }

        //execute query
        $this->_deleteStatement->execute(array('id' => $id));
    }

    /**
     * Insert record into table TechnologyCategory
     * @param TechnologyCategory $technologyCategory primary key
     */
    public function insert($technologyCategory) {
        //create the statement
        $attributes = self::check($technologyCategory);
        $statement = 'INSERT INTO TechnologyCategory(';
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
     * Update record from table TechnologyCategory
     * @param TechnologyCategory $technologyCategory primary key
     */
    public function update($technologyCategory) {
        //create the statement
        $attributes = self::check($technologyCategory);
        $statement = 'UPDATE TechnologyCategory SET ';
        foreach($attributes as &$attribute)
            $statement .= $attribute[0].' = '.$attribute[1].', ';
        $statement = rtrim($statement, ', ');
        $statement .= ' WHERE idTechnologyCategory = '.$technologyCategory->getId();

        //prepare and execute the statement
        $query = Connection::getConnection()->prepare($statement);
        $query->execute();
    }
}
