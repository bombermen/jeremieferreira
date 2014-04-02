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

    /*
     * @var PDOStatement
     */
    private $_selectByIdTechnologyStatement;

    /*
     * @var PDOStatement
     */
    private $_deleteTechnologyCategoryTechnologysStatement;

    /*
     * @var PDOStatement
     */
    private $_insertTechnologyCategoryTechnologysStatement;

    /**
     * Get domain object TechnologyCategory by primary key
     * @param int $id primary key
     * @return TechnologyCategory
     */
    public function load($id) {
        //initialize the prepared statement if it is not
        if(!isset($this->_loadStatement)) {
            $statement = 'SELECT idTechnologyCategory AS id, name, visible, description FROM TechnologyCategory WHERE idTechnologyCategory = :id';
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
     * Select all TechnologyCategory records refering to Technology
     * @return TechnologyCategory|Array
     */
    public function selectByIdTechnology($idTechnology) {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllStatement)) {
            $statement = 'SELECT idTechnologyCategory AS id, name, visible, description FROM TechnologyCategory NATURAL JOIN Technology WHERE idTechnology = :idTechnology';
            $this->_selectByIdTechnologyStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as TechnologyCategory instances array and return it
        $this->_selectByIdTechnologyStatement->execute(array('idTechnology' => $idTechnology));
        $this->_selectByIdTechnologyStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectByIdTechnologyStatement->fetch())
            $result[] = new TechnologyCategory($line);
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
            $statement = 'SELECT idTechnologyCategory AS id, name, visible, description FROM TechnologyCategory';
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
        if(!isset($this->_selectAllOrderByStatement)) {
            $statement = 'SELECT idTechnologyCategory AS id, name, visible, description FROM TechnologyCategory ORDER BY '.$column;
            $this->_selectAllOrderByStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as TechnologyCategory instances array and return it
        $this->_selectAllOrderByStatement->execute();
        $this->_selectAllOrderByStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectAllOrderByStatement->fetch())
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
        $attributes = $technologyCategory->getNotNullValues();
        $columns = array();
        $values = array();
        foreach($attributes as $key => $value) {
            $columns[] = $key;
            $values[] = $value;
        }
        $statement = 'INSERT INTO TechnologyCategory('.implode(', ', $columns).') VALUES ('.implode(', ', $values).')';
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
        $attributes = $technologyCategory->check();
        $statement = 'UPDATE TechnologyCategory SET ';
        foreach($attributes as &$attribute)
            $statement .= $attribute.getName().' = '.$attribute.getType().', ';
        $statement = rtrim($statement, ', ');
        $statement .= ' WHERE idTechnologyCategory = '.$technologyCategory->getId();

        //prepare and execute the statement
        $query = Connection::getConnection()->prepare($statement);
        $query->execute();
    }
    /**
    * Update all the records of technologys for the selected technologyCategory
    * @param TechnologyCategory selected + technologyCategory
    */
    public function updateTechnologys($technologyCategory) {
        //get all the existing records for this technologyCategory
        $existing = Domain::domainArrayAsIdArray( selectByIdTechnology($technologyCategory->getId()) );
        $target = Domain::domainArrayAsIdArray( $technologyCategory->getTechnologys);

        //get all records to add as a string : '(idTechnologyCategory, idTechnology), (idTechnologyCategory, idTechnology), ...)'
        $toAdd = array_diff($target, $existing);
        foreach($toAdd as &$item) {
            $item = implode(', ', array($technologyCategory->getId(), $item));
        }
        $toAdd = '('.implode('), (', $toAdd).')';

        //prepare statements if not set
        if( !isset($this->_deleteTechnologyCategoryTechnologyStatement) ) {
            $cnx = Connection::getConnection();

            //delete statement
            $statement = 'DELETE * FROM null WHERE idTechnologyCategory = :idTechnologyCategory AND idTechnology NOT IN (:target)';
            $this->_deleteTechnologyCategoryTechnologysStatement = $cnx->prepareStatement($statement);

            //delete statement
            $statement = 'INSERT INTO null (idTechnologyCategory, idTechnology) VALUES :insert';
            $this->_insertTechnologyCategoryTechnologysStatement = $cnx->prepareStatement($statement);
        }

        $this->_deleteTechnologyCategoryTechnologysStatement->execute( array('target' => implode(', ', $target)) );
        $this->_insertTechnologyCategoryTechnologysStatement->execute( array('target' => implode(', ', $toAdd)) );
    }
}
