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

    /*
     * @var PDOStatement
     */
    private $_selectByIdPublicationStatement;

    /*
     * @var PDOStatement
     */
    private $_deleteTechnologyPublicationsStatement;

    /*
     * @var PDOStatement
     */
    private $_insertTechnologyPublicationsStatement;

    /**
     * Get domain object Technology by primary key
     * @param int $id primary key
     * @return Technology
     */
    public function load($id) {
        //initialize the prepared statement if it is not
        if(!isset($this->_loadStatement)) {
            $statement = 'SELECT idTechnology AS id, name, description FROM Technology WHERE idTechnology = :id';
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
     * Select all Technology records refering to Publication
     * @return Technology|Array
     */
    public function selectByIdPublication($idPublication) {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllStatement)) {
            $statement = 'SELECT idTechnology AS id, name, description FROM Technology NATURAL JOIN Publication WHERE idPublication = :idPublication';
            $this->_selectByIdPublicationStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as Technology instances array and return it
        $this->_selectByIdPublicationStatement->execute(array('idPublication' => $idPublication));
        $this->_selectByIdPublicationStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectByIdPublicationStatement->fetch())
            $result[] = new Technology($line);
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
            $statement = 'SELECT idTechnology AS id, name, description FROM Technology';
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
        if(!isset($this->_selectAllOrderByStatement)) {
            $statement = 'SELECT idTechnology AS id, name, description FROM Technology ORDER BY '.$column;
            $this->_selectAllOrderByStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as Technology instances array and return it
        $this->_selectAllOrderByStatement->execute();
        $this->_selectAllOrderByStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectAllOrderByStatement->fetch())
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
        $attributes = $technology->getNotNullValues();
        $columns = array();
        $values = array();
        foreach($attributes as $key => $value) {
            $columns[] = $key;
            $values[] = $value;
        }
        $statement = 'INSERT INTO Technology('.implode(', ', $columns).') VALUES ('.implode(', ', $values).')';
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
        $attributes = $technology->check();
        $statement = 'UPDATE Technology SET ';
        foreach($attributes as &$attribute)
            $statement .= $attribute.getName().' = '.$attribute.getType().', ';
        $statement = rtrim($statement, ', ');
        $statement .= ' WHERE idTechnology = '.$technology->getId();

        //prepare and execute the statement
        $query = Connection::getConnection()->prepare($statement);
        $query->execute();
    }
    /**
    * Update all the records of publications for the selected technology
    * @param Technology selected + technology
    */
    public function updatePublications($technology) {
        //get all the existing records for this technology
        $existing = Domain::domainArrayAsIdArray( selectByIdPublication($technology->getId()) );
        $target = Domain::domainArrayAsIdArray( $technology->getPublications);

        //get all records to add as a string : '(idTechnology, idPublication), (idTechnology, idPublication), ...)'
        $toAdd = array_diff($target, $existing);
        foreach($toAdd as &$item) {
            $item = implode(', ', array($technology->getId(), $item));
        }
        $toAdd = '('.implode('), (', $toAdd).')';

        //prepare statements if not set
        if( !isset($this->_deleteTechnologyPublicationStatement) ) {
            $cnx = Connection::getConnection();

            //delete statement
            $statement = 'DELETE * FROM Publication_involves_Technology WHERE idTechnology = :idTechnology AND idPublication NOT IN (:target)';
            $this->_deleteTechnologyPublicationsStatement = $cnx->prepareStatement($statement);

            //delete statement
            $statement = 'INSERT INTO Publication_involves_Technology (idTechnology, idPublication) VALUES :insert';
            $this->_insertTechnologyPublicationsStatement = $cnx->prepareStatement($statement);
        }

        $this->_deleteTechnologyPublicationsStatement->execute( array('target' => implode(', ', $target)) );
        $this->_insertTechnologyPublicationsStatement->execute( array('target' => implode(', ', $toAdd)) );
    }
}
