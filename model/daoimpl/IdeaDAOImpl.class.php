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

    /*
     * @var PDOStatement
     */
    private $_selectByIdPublicationStatement;

    /*
     * @var PDOStatement
     */
    private $_deleteIdeaPublicationsStatement;

    /*
     * @var PDOStatement
     */
    private $_insertIdeaPublicationsStatement;

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
     * Select all Idea records refering to Publication
     * @return Idea|Array
     */
    public function selectByIdPublication($idPublication) {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllStatement)) {
            $statement = 'SELECT idIdea AS id, UNIX_TIMESTAMP(postDate) AS postDate FROM Idea NATURAL JOIN Publication WHERE idPublication = :idPublication';
            $this->_selectByIdPublicationStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as Idea instances array and return it
        $this->_selectByIdPublicationStatement->execute(array('idPublication' => $idPublication));
        $this->_selectByIdPublicationStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectByIdPublicationStatement->fetch())
            $result[] = new Idea($line);
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
        if(!isset($this->_selectAllOrderByStatement)) {
            $statement = 'SELECT idIdea AS id, UNIX_TIMESTAMP(postDate) AS postDate FROM Idea ORDER BY '.$column;
            $this->_selectAllOrderByStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as Idea instances array and return it
        $this->_selectAllOrderByStatement->execute();
        $this->_selectAllOrderByStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectAllOrderByStatement->fetch())
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
        $attributes = $idea->getNotNullValues();
        $columns = array();
        $values = array();
        foreach($attributes as $key => $value) {
            $columns[] = $key;
            $values[] = $value;
        }
        $statement = 'INSERT INTO Idea('.implode(', ', $columns).') VALUES ('.implode(', ', $values).')';
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
        $attributes = $idea->check();
        $statement = 'UPDATE Idea SET ';
        foreach($attributes as &$attribute)
            $statement .= $attribute.getName().' = '.$attribute.getType().', ';
        $statement = rtrim($statement, ', ');
        $statement .= ' WHERE idIdea = '.$idea->getId();

        //prepare and execute the statement
        $query = Connection::getConnection()->prepare($statement);
        $query->execute();
    }
    /**
    * Update all the records of publications for the selected idea
    * @param Idea selected + idea
    */
    public function updatePublications($idea) {
        //get all the existing records for this idea
        $existing = Domain::domainArrayAsIdArray( selectByIdPublication($idea->getId()) );
        $target = Domain::domainArrayAsIdArray( $idea->getPublications);

        //get all records to add as a string : '(idIdea, idPublication), (idIdea, idPublication), ...)'
        $toAdd = array_diff($target, $existing);
        foreach($toAdd as &$item) {
            $item = implode(', ', array($idea->getId(), $item));
        }
        $toAdd = '('.implode('), (', $toAdd).')';

        //prepare statements if not set
        if( !isset($this->_deleteIdeaPublicationStatement) ) {
            $cnx = Connection::getConnection();

            //delete statement
            $statement = 'DELETE * FROM Idea_inspired_Publication WHERE idIdea = :idIdea AND idPublication NOT IN (:target)';
            $this->_deleteIdeaPublicationsStatement = $cnx->prepareStatement($statement);

            //delete statement
            $statement = 'INSERT INTO Idea_inspired_Publication (idIdea, idPublication) VALUES :insert';
            $this->_insertIdeaPublicationsStatement = $cnx->prepareStatement($statement);
        }

        $this->_deleteIdeaPublicationsStatement->execute( array('target' => implode(', ', $target)) );
        $this->_insertIdeaPublicationsStatement->execute( array('target' => implode(', ', $toAdd)) );
    }
}
