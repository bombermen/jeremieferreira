<?php

/**
 * Description of PublicationDAOImpl implements PublicationDAO
 *
 * @author Jeremie FERREIRA
 */
class PublicationDAOImpl implements PublicationDAO {
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
    private $_selectByIdPersonStatement;

    /*
     * @var PDOStatement
     */
    private $_deletePublicationPersonsStatement;

    /*
     * @var PDOStatement
     */
    private $_insertPublicationPersonsStatement;

    /*
     * @var PDOStatement
     */
    private $_selectByIdIdeaStatement;

    /*
     * @var PDOStatement
     */
    private $_deletePublicationIdeasStatement;

    /*
     * @var PDOStatement
     */
    private $_insertPublicationIdeasStatement;

    /*
     * @var PDOStatement
     */
    private $_selectByIdTechnologyStatement;

    /*
     * @var PDOStatement
     */
    private $_deletePublicationTechnologiesStatement;

    /*
     * @var PDOStatement
     */
    private $_insertPublicationTechnologiesStatement;

    /*
     * @var PDOStatement
     */
    private $_selectByIdTagStatement;

    /*
     * @var PDOStatement
     */
    private $_deletePublicationTagsStatement;

    /*
     * @var PDOStatement
     */
    private $_insertPublicationTagsStatement;

    /**
     * Get domain object Publication by primary key
     * @param int $id primary key
     * @return Publication
     */
    public function load($id) {
        //initialize the prepared statement if it is not
        if(!isset($this->_loadStatement)) {
            $statement = 'SELECT idPublication AS id, title, shortDescription, sourcesUrl, visits FROM Publication WHERE idPublication = :id';
            $this->_loadStatement = Connection::getConnection()->prepare($statement);
        }

        //get the first result and return it after closing the cursor
        $this->_loadStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->_loadStatement->execute(array('id' => $id));
        $line = $this->_loadStatement->fetch();
        $this->_loadStatement->closeCursor();
        $result = new Publication($line);
        return $result;
    }

    /**
     * Select all Publication records refering to Person
     * @return Publication|Array
     */
    public function selectByIdPerson($idPerson) {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllStatement)) {
            $statement = 'SELECT idPublication AS id, title, shortDescription, sourcesUrl, visits FROM Publication NATURAL JOIN Person WHERE idPerson = :idPerson';
            $this->_selectByIdPersonStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as Publication instances array and return it
        $this->_selectByIdPersonStatement->execute(array('idPerson' => $idPerson));
        $this->_selectByIdPersonStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectByIdPersonStatement->fetch())
            $result[] = new Publication($line);
        return $result;
    }

    /**
     * Select all Publication records refering to Idea
     * @return Publication|Array
     */
    public function selectByIdIdea($idIdea) {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllStatement)) {
            $statement = 'SELECT idPublication AS id, title, shortDescription, sourcesUrl, visits FROM Publication NATURAL JOIN Idea WHERE idIdea = :idIdea';
            $this->_selectByIdIdeaStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as Publication instances array and return it
        $this->_selectByIdIdeaStatement->execute(array('idIdea' => $idIdea));
        $this->_selectByIdIdeaStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectByIdIdeaStatement->fetch())
            $result[] = new Publication($line);
        return $result;
    }

    /**
     * Select all Publication records refering to Technology
     * @return Publication|Array
     */
    public function selectByIdTechnology($idTechnology) {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllStatement)) {
            $statement = 'SELECT idPublication AS id, title, shortDescription, sourcesUrl, visits FROM Publication NATURAL JOIN Technology WHERE idTechnology = :idTechnology';
            $this->_selectByIdTechnologyStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as Publication instances array and return it
        $this->_selectByIdTechnologyStatement->execute(array('idTechnology' => $idTechnology));
        $this->_selectByIdTechnologyStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectByIdTechnologyStatement->fetch())
            $result[] = new Publication($line);
        return $result;
    }

    /**
     * Select all Publication records refering to Tag
     * @return Publication|Array
     */
    public function selectByIdTag($idTag) {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllStatement)) {
            $statement = 'SELECT idPublication AS id, title, shortDescription, sourcesUrl, visits FROM Publication NATURAL JOIN Tag WHERE idTag = :idTag';
            $this->_selectByIdTagStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as Publication instances array and return it
        $this->_selectByIdTagStatement->execute(array('idTag' => $idTag));
        $this->_selectByIdTagStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectByIdTagStatement->fetch())
            $result[] = new Publication($line);
        return $result;
    }

    /**
     * Get all records from table Publication
     * @return Publication|Array
     */
    public function selectAll() {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllStatement)) {
            $statement = 'SELECT idPublication AS id, title, shortDescription, sourcesUrl, visits FROM Publication';
            $this->_selectAllStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as Publication instances array and return it
        $this->_selectAllStatement->execute();
        $this->_selectAllStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectAllStatement->fetch())
            $result[] = new Publication($line);
        return $result;
    }

    /**
     * Get all records from table ordered by a column Publication
     * @param string $column column name
     * @return Publication|Array
     */
    public function selectAllOrderBy($column) {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllOrderByStatement)) {
            $statement = 'SELECT idPublication AS id, title, shortDescription, sourcesUrl, visits FROM Publication ORDER BY '.$column;
            $this->_selectAllOrderByStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as Publication instances array and return it
        $this->_selectAllOrderByStatement->execute();
        $this->_selectAllOrderByStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectAllOrderByStatement->fetch())
            $result[] = new Publication($line);
        return $result;
    }

    /**
     * Delete from Publication table by primary key
     * @param int $id primary key
     */
    public function delete($id) {
        //initialize the prepared statement if it is not
        if(!isset($this->_deleteStatement)) {
            $statement = 'DELETE FROM Publication WHERE idPublication = :id';
            $this->_deleteStatement = Connection::getConnection()->prepare($statement);
        }

        //execute query
        $this->_deleteStatement->execute(array('id' => $id));
    }

    /**
     * Insert record into table Publication
     * @param Publication $publication primary key
     */
    public function insert($publication) {
        //create the statement
        $attributes = $publication->getNotNullValues();
        $columns = array();
        $values = array();
        foreach($attributes as $key => $value) {
            $columns[] = $key;
            $values[] = $value;
        }
        $statement = 'INSERT INTO Publication('.implode(', ', $columns).') VALUES ('.implode(', ', $values).')';
        //prepare and execute the statement
        $query = Connection::getConnection()->prepare($statement);
        $query->execute();
    }

    /**
     * Update record from table Publication
     * @param Publication $publication primary key
     */
    public function update($publication) {
        //create the statement
        $attributes = $publication->check();
        $statement = 'UPDATE Publication SET ';
        foreach($attributes as &$attribute)
            $statement .= $attribute.getName().' = '.$attribute.getType().', ';
        $statement = rtrim($statement, ', ');
        $statement .= ' WHERE idPublication = '.$publication->getId();

        //prepare and execute the statement
        $query = Connection::getConnection()->prepare($statement);
        $query->execute();
    }
    /**
    * Update all the records of persons for the selected publication
    * @param Publication selected + publication
    */
    public function updatePersons($publication) {
        //get all the existing records for this publication
        $existing = Domain::domainArrayAsIdArray( selectByIdPerson($publication->getId()) );
        $target = Domain::domainArrayAsIdArray( $publication->getPersons);

        //get all records to add as a string : '(idPublication, idPerson), (idPublication, idPerson), ...)'
        $toAdd = array_diff($target, $existing);
        foreach($toAdd as &$item) {
            $item = implode(', ', array($publication->getId(), $item));
        }
        $toAdd = '('.implode('), (', $toAdd).')';

        //prepare statements if not set
        if( !isset($this->_deletePublicationPersonStatement) ) {
            $cnx = Connection::getConnection();

            //delete statement
            $statement = 'DELETE * FROM Person_collaboratesTo_Publication WHERE idPublication = :idPublication AND idPerson NOT IN (:target)';
            $this->_deletePublicationPersonsStatement = $cnx->prepareStatement($statement);

            //delete statement
            $statement = 'INSERT INTO Person_collaboratesTo_Publication (idPublication, idPerson) VALUES :insert';
            $this->_insertPublicationPersonsStatement = $cnx->prepareStatement($statement);
        }

        $this->_deletePublicationPersonsStatement->execute( array('target' => implode(', ', $target)) );
        $this->_insertPublicationPersonsStatement->execute( array('target' => implode(', ', $toAdd)) );
    }
    /**
    * Update all the records of ideas for the selected publication
    * @param Publication selected + publication
    */
    public function updateIdeas($publication) {
        //get all the existing records for this publication
        $existing = Domain::domainArrayAsIdArray( selectByIdIdea($publication->getId()) );
        $target = Domain::domainArrayAsIdArray( $publication->getIdeas);

        //get all records to add as a string : '(idPublication, idIdea), (idPublication, idIdea), ...)'
        $toAdd = array_diff($target, $existing);
        foreach($toAdd as &$item) {
            $item = implode(', ', array($publication->getId(), $item));
        }
        $toAdd = '('.implode('), (', $toAdd).')';

        //prepare statements if not set
        if( !isset($this->_deletePublicationIdeaStatement) ) {
            $cnx = Connection::getConnection();

            //delete statement
            $statement = 'DELETE * FROM Idea_inspired_Publication WHERE idPublication = :idPublication AND idIdea NOT IN (:target)';
            $this->_deletePublicationIdeasStatement = $cnx->prepareStatement($statement);

            //delete statement
            $statement = 'INSERT INTO Idea_inspired_Publication (idPublication, idIdea) VALUES :insert';
            $this->_insertPublicationIdeasStatement = $cnx->prepareStatement($statement);
        }

        $this->_deletePublicationIdeasStatement->execute( array('target' => implode(', ', $target)) );
        $this->_insertPublicationIdeasStatement->execute( array('target' => implode(', ', $toAdd)) );
    }
    /**
    * Update all the records of technologies for the selected publication
    * @param Publication selected + publication
    */
    public function updateTechnologies($publication) {
        //get all the existing records for this publication
        $existing = Domain::domainArrayAsIdArray( selectByIdTechnology($publication->getId()) );
        $target = Domain::domainArrayAsIdArray( $publication->getTechnologies);

        //get all records to add as a string : '(idPublication, idTechnology), (idPublication, idTechnology), ...)'
        $toAdd = array_diff($target, $existing);
        foreach($toAdd as &$item) {
            $item = implode(', ', array($publication->getId(), $item));
        }
        $toAdd = '('.implode('), (', $toAdd).')';

        //prepare statements if not set
        if( !isset($this->_deletePublicationTechnologyStatement) ) {
            $cnx = Connection::getConnection();

            //delete statement
            $statement = 'DELETE * FROM Publication_involves_Technology WHERE idPublication = :idPublication AND idTechnology NOT IN (:target)';
            $this->_deletePublicationTechnologiesStatement = $cnx->prepareStatement($statement);

            //delete statement
            $statement = 'INSERT INTO Publication_involves_Technology (idPublication, idTechnology) VALUES :insert';
            $this->_insertPublicationTechnologiesStatement = $cnx->prepareStatement($statement);
        }

        $this->_deletePublicationTechnologiesStatement->execute( array('target' => implode(', ', $target)) );
        $this->_insertPublicationTechnologiesStatement->execute( array('target' => implode(', ', $toAdd)) );
    }
    /**
    * Update all the records of tags for the selected publication
    * @param Publication selected + publication
    */
    public function updateTags($publication) {
        //get all the existing records for this publication
        $existing = Domain::domainArrayAsIdArray( selectByIdTag($publication->getId()) );
        $target = Domain::domainArrayAsIdArray( $publication->getTags);

        //get all records to add as a string : '(idPublication, idTag), (idPublication, idTag), ...)'
        $toAdd = array_diff($target, $existing);
        foreach($toAdd as &$item) {
            $item = implode(', ', array($publication->getId(), $item));
        }
        $toAdd = '('.implode('), (', $toAdd).')';

        //prepare statements if not set
        if( !isset($this->_deletePublicationTagStatement) ) {
            $cnx = Connection::getConnection();

            //delete statement
            $statement = 'DELETE * FROM Publication_has_Tag WHERE idPublication = :idPublication AND idTag NOT IN (:target)';
            $this->_deletePublicationTagsStatement = $cnx->prepareStatement($statement);

            //delete statement
            $statement = 'INSERT INTO Publication_has_Tag (idPublication, idTag) VALUES :insert';
            $this->_insertPublicationTagsStatement = $cnx->prepareStatement($statement);
        }

        $this->_deletePublicationTagsStatement->execute( array('target' => implode(', ', $target)) );
        $this->_insertPublicationTagsStatement->execute( array('target' => implode(', ', $toAdd)) );
    }
}
