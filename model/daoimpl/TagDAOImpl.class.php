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

    /*
     * @var PDOStatement
     */
    private $_selectByIdPublicationStatement;

    /*
     * @var PDOStatement
     */
    private $_deleteTagPublicationsStatement;

    /*
     * @var PDOStatement
     */
    private $_insertTagPublicationsStatement;

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
     * Select all Tag records refering to Publication
     * @return Tag|Array
     */
    public function selectByIdPublication($idPublication) {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllStatement)) {
            $statement = 'SELECT idTag AS id, name FROM Tag NATURAL JOIN Publication WHERE idPublication = :idPublication';
            $this->_selectByIdPublicationStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as Tag instances array and return it
        $this->_selectByIdPublicationStatement->execute(array('idPublication' => $idPublication));
        $this->_selectByIdPublicationStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectByIdPublicationStatement->fetch())
            $result[] = new Tag($line);
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
        if(!isset($this->_selectAllOrderByStatement)) {
            $statement = 'SELECT idTag AS id, name FROM Tag ORDER BY '.$column;
            $this->_selectAllOrderByStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as Tag instances array and return it
        $this->_selectAllOrderByStatement->execute();
        $this->_selectAllOrderByStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectAllOrderByStatement->fetch())
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
        $attributes = $tag->getNotNullValues();
        $columns = array();
        $values = array();
        foreach($attributes as $key => $value) {
            $columns[] = $key;
            $values[] = $value;
        }
        $statement = 'INSERT INTO Tag('.implode(', ', $columns).') VALUES ('.implode(', ', $values).')';
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
        $attributes = $tag->check();
        $statement = 'UPDATE Tag SET ';
        foreach($attributes as &$attribute)
            $statement .= $attribute.getName().' = '.$attribute.getType().', ';
        $statement = rtrim($statement, ', ');
        $statement .= ' WHERE idTag = '.$tag->getId();

        //prepare and execute the statement
        $query = Connection::getConnection()->prepare($statement);
        $query->execute();
    }
    /**
    * Update all the records of publications for the selected tag
    * @param Tag selected + tag
    */
    public function updatePublications($tag) {
        //get all the existing records for this tag
        $existing = Domain::domainArrayAsIdArray( selectByIdPublication($tag->getId()) );
        $target = Domain::domainArrayAsIdArray( $tag->getPublications);

        //get all records to add as a string : '(idTag, idPublication), (idTag, idPublication), ...)'
        $toAdd = array_diff($target, $existing);
        foreach($toAdd as &$item) {
            $item = implode(', ', array($tag->getId(), $item));
        }
        $toAdd = '('.implode('), (', $toAdd).')';

        //prepare statements if not set
        if( !isset($this->_deleteTagPublicationStatement) ) {
            $cnx = Connection::getConnection();

            //delete statement
            $statement = 'DELETE * FROM Publication_has_Tag WHERE idTag = :idTag AND idPublication NOT IN (:target)';
            $this->_deleteTagPublicationsStatement = $cnx->prepareStatement($statement);

            //delete statement
            $statement = 'INSERT INTO Publication_has_Tag (idTag, idPublication) VALUES :insert';
            $this->_insertTagPublicationsStatement = $cnx->prepareStatement($statement);
        }

        $this->_deleteTagPublicationsStatement->execute( array('target' => implode(', ', $target)) );
        $this->_insertTagPublicationsStatement->execute( array('target' => implode(', ', $toAdd)) );
    }
}
