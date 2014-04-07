<?php

/**
 * Description of PublicationDAO implements DAO
 *
 * @author Jeremie FERREIRA
 */
class PublicationDAO implements DAO {
    /**
     * Get domain object Publication by primary key
     * @param int $id primary key
     * @return Publication
     */
    public function load($id) {
        $statement = 'SELECT idPublication AS id,title,shortDescription,sourcesUrl,visits,category,state FROM Publication WHERE idPublication = :id';
        $query = Connection::getConnection()->prepare($statement);

        //get the first result and return it after closing the cursor
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $line = $query->fetch();
        $query->closeCursor();
        $result = Publication::parseArray($line);
        return $result;
    }

    /**
     * Select all Publication records refering to Person
     * @return Publication|Array
     */
    public function selectByIdPerson($idPerson) {
        $result = array();
        $statement = 'SELECT idPublication AS id, title, shortDescription, sourcesUrl, visits, category, state FROM Publication ref INNER JOIN Person_collaboratesTo_Publication asso ON ref.idPublication = asso.publication WHERE Person = :idPerson';
        $query = Connection::getConnection()->prepare($statement);

        //Get the results as Publication instances array and return it
        $query->bindParam(':idPerson', $idPerson, PDO::PARAM_INT);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        while($line = $query->fetch())
            $result[] = Publication::parseArray($line);
        return $result;
    }

    /**
     * Select all Publication records refering to Idea
     * @return Publication|Array
     */
    public function selectByIdIdea($idIdea) {
        $result = array();
        $statement = 'SELECT idPublication AS id, title, shortDescription, sourcesUrl, visits, category, state FROM Publication ref INNER JOIN Idea_inspired_Publication asso ON ref.idPublication = asso.publication WHERE Idea = :idIdea';
        $query = Connection::getConnection()->prepare($statement);

        //Get the results as Publication instances array and return it
        $query->bindParam(':idIdea', $idIdea, PDO::PARAM_INT);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        while($line = $query->fetch())
            $result[] = Publication::parseArray($line);
        return $result;
    }

    /**
     * Select all Publication records refering to Technology
     * @return Publication|Array
     */
    public function selectByIdTechnology($idTechnology) {
        $result = array();
        $statement = 'SELECT idPublication AS id, title, shortDescription, sourcesUrl, visits, category, state FROM Publication ref INNER JOIN Publication_involves_Technology asso ON ref.idPublication = asso.publication WHERE Technology = :idTechnology';
        $query = Connection::getConnection()->prepare($statement);

        //Get the results as Publication instances array and return it
        $query->bindParam(':idTechnology', $idTechnology, PDO::PARAM_INT);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        while($line = $query->fetch())
            $result[] = Publication::parseArray($line);
        return $result;
    }

    /**
     * Select all Publication records refering to Tag
     * @return Publication|Array
     */
    public function selectByIdTag($idTag) {
        $result = array();
        $statement = 'SELECT idPublication AS id, title, shortDescription, sourcesUrl, visits, category, state FROM Publication ref INNER JOIN Publication_has_Tag asso ON ref.idPublication = asso.publication WHERE Tag = :idTag';
        $query = Connection::getConnection()->prepare($statement);

        //Get the results as Publication instances array and return it
        $query->bindParam(':idTag', $idTag, PDO::PARAM_INT);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        while($line = $query->fetch())
            $result[] = Publication::parseArray($line);
        return $result;
    }

    /**
     * Select all Publication records refering to Category
     * @return Publication|Array
     */
    public function selectByIdCategory($idCategory) {
        $result = array();
        $statement = 'SELECT idPublication AS id, title, shortDescription, sourcesUrl, visits, category, state FROM Publication ref INNER JOIN null asso ON ref.idPublication = asso.publication WHERE Category = :idCategory';
        $query = Connection::getConnection()->prepare($statement);

        //Get the results as Publication instances array and return it
        $query->bindParam(':idCategory', $idCategory, PDO::PARAM_INT);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        while($line = $query->fetch())
            $result[] = Publication::parseArray($line);
        return $result;
    }

    /**
     * Select all Publication records refering to State
     * @return Publication|Array
     */
    public function selectByIdState($idState) {
        $result = array();
        $statement = 'SELECT idPublication AS id, title, shortDescription, sourcesUrl, visits, category, state FROM Publication ref INNER JOIN null asso ON ref.idPublication = asso.publication WHERE State = :idState';
        $query = Connection::getConnection()->prepare($statement);

        //Get the results as Publication instances array and return it
        $query->bindParam(':idState', $idState, PDO::PARAM_INT);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        while($line = $query->fetch())
            $result[] = Publication::parseArray($line);
        return $result;
    }

    /**
     * Get all records from table Publication
     * @return Publication|Array
     */
    public function selectAll() {
        $result = array();
        $statement = 'SELECT idPublication AS id, title, shortDescription, sourcesUrl, visits, category, state FROM Publication';
        $query = Connection::getConnection()->prepare($statement);

        //Get the results as Publication instance array and return it
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $query->fetch())
            $result[] = Publication::parseArray($line);
        return $result;
    }

    /**
     * Get all records from table ordered by a column Publication
     * @param string $column column name
     * @return Publication|Array
     */
    public function selectAllOrderBy($column, $asc = true) {
        $result = array();
        $sorting = $asc ? ' ASC' : ' DESC';
        $statement = 'SELECT idPublication AS id, title, shortDescription, sourcesUrl, visits, category, state FROM Publication ORDER BY '.$column.$sorting;
        $query = Connection::getConnection()->prepare($statement);
        $query->bindParam(':column', $column, PDO::PARAM_STR);
        //Get the results as Publication instance array and return it

        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        while($line = $query->fetch())
            $result[] = Publication::parseArray($line);
        return $result;
    }

    /**
     * Delete from Publication table by primary key
     * @param int $id primary key
     */
    public function delete($id) {
        $statement = 'DELETE FROM Publication WHERE idPublication = :id';
        $query = Connection::getConnection()->prepare($statement);

        $query->bindParam(':id', $id, PDO::PARAM_INT);
        //execute query
        $query->execute(array('id' => $id));
    }

    /**
     * Insert record into table Publication
     * @param Publication $publication data to insert
     */
    public function insert($publication) {
        //create the statement
        $statement = 'INSERT INTO Publication (title, shortDescription, sourcesUrl, visits, category, state) VALUES (:title, :shortDescription, :sourcesUrl, :visits, :category, :state)';
        $query = Connection::getConnection()->prepare($statement);

        //bind parameters and execute query
        $title = $publication->getTitle();
        $shortDescription = $publication->getShortDescription();
        $visits = $publication->getVisits();
        $category = $publication->getCategory()->getId();
        $state = $publication->getState()->getId();

        if( !is_null( $publication->getSourcesUrl() ) )
            $sourcesUrl = $publication->getSourcesUrl();
        else
            $sourcesUrl = null;

        $query->bindParam(':title', $title, PDO::PARAM_STR, 255);
        $query->bindParam(':shortDescription', $shortDescription, PDO::PARAM_STR, 255);
        $query->bindParam(':visits', $visits, PDO::PARAM_INT);
        $query->bindParam(':category', $category, PDO::PARAM_INT);
        $query->bindParam(':state', $state, PDO::PARAM_INT);

        if( is_null( $sourcesUrl ) )
            $query->bindParam(':sourcesUrl', $sourcesUrl, PDO::PARAM_NULL);
        else
            $query->bindParam(':sourcesUrl', $sourcesUrl, PDO::PARAM_STR, 255);

        $query->execute();
    }

    /**
     * Associate persons with one publication
     * @param int $idPersons
     * @param int|Array $personIds
     */
    private function insertPersons($idPublication, array $personIds) {
        $statement = 'INSERT INTO Person_collaboratesTo_Publication (publication, person) VALUES (:idPublication, :idPerson)';
        $query = Connection::getConnection()->prepare($statement);
        
        foreach($personIds as $idPerson) {
            $query->bindParam(':idPublication', $idPublication, PDO::PARAM_INT);
            $query->bindParam(':idPerson', $idPerson, PDO::PARAM_INT);
            $query->execute();
        }
    }

    /**
     * Disassociate persons from one publication
     * @param int $idPublication
     * @param int|Array $personIds
     */
    private function deletePersons($idPublication, $personIds = array()) {
        //init query
        $statement = 'DELETE FROM Person_collaboratesTo_Publication WHERE publication = :idPublication AND person = :idPerson';
        $query = Connection::getConnection()->prepare($statement);
        
        //execute on each person
        foreach($personIds as $idPerson) {
            $query->bindParam(':idPublication', $idPublication, PDO::PARAM_INT);
            $query->bindParam(':idPerson', $idPerson, PDO::PARAM_INT);
            $query->execute();
        }
    }

    /**
     * Update a Publication Person list according to the object data
     * @param Publication $publication
     */
    public function updatePersons($publication) {
        //search existing data
        $idPublication = $publication->getId();
        $connection = Connection::getConnection();
        $statement = 'SELECT person FROM Person_collaboratesTo_Publication WHERE publication = :idPublication';
        $query = $connection->prepare($statement);
        $query->bindParam(':idPublication', $idPublication, PDO::PARAM_INT);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_COLUMN, 0);
        $records = $query->fetchAll();
        
        //sort data to delete/insert
        $personIds = Utilities::getIds($publication->getPersons());
        
        $deleteList = array_diff($records, $personIds);
        $insertList = array_diff($personIds, $records);
        
        //delete/insert data
        $connection->beginTransaction();
        try {
            $this->deletePersons($idPublication, $deleteList);
            $this->insertPersons($idPublication, $insertList);
            $connection->commit();
        } catch (Exception $e) {
            $connection->rollback();
        }
    }

    /**
     * Associate ideas with one publication
     * @param int $idIdeas
     * @param int|Array $ideaIds
     */
    private function insertIdeas($idPublication, array $ideaIds) {
        $statement = 'INSERT INTO Idea_inspired_Publication (publication, idea) VALUES (:idPublication, :idIdea)';
        $query = Connection::getConnection()->prepare($statement);
        
        foreach($ideaIds as $idIdea) {
            $query->bindParam(':idPublication', $idPublication, PDO::PARAM_INT);
            $query->bindParam(':idIdea', $idIdea, PDO::PARAM_INT);
            $query->execute();
        }
    }

    /**
     * Disassociate ideas from one publication
     * @param int $idPublication
     * @param int|Array $ideaIds
     */
    private function deleteIdeas($idPublication, $ideaIds = array()) {
        //init query
        $statement = 'DELETE FROM Idea_inspired_Publication WHERE publication = :idPublication AND idea = :idIdea';
        $query = Connection::getConnection()->prepare($statement);
        
        //execute on each idea
        foreach($ideaIds as $idIdea) {
            $query->bindParam(':idPublication', $idPublication, PDO::PARAM_INT);
            $query->bindParam(':idIdea', $idIdea, PDO::PARAM_INT);
            $query->execute();
        }
    }

    /**
     * Update a Publication Idea list according to the object data
     * @param Publication $publication
     */
    public function updateIdeas($publication) {
        //search existing data
        $idPublication = $publication->getId();
        $connection = Connection::getConnection();
        $statement = 'SELECT idea FROM Idea_inspired_Publication WHERE publication = :idPublication';
        $query = $connection->prepare($statement);
        $query->bindParam(':idPublication', $idPublication, PDO::PARAM_INT);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_COLUMN, 0);
        $records = $query->fetchAll();
        
        //sort data to delete/insert
        $ideaIds = Utilities::getIds($publication->getIdeas());
        
        $deleteList = array_diff($records, $ideaIds);
        $insertList = array_diff($ideaIds, $records);
        
        //delete/insert data
        $connection->beginTransaction();
        try {
            $this->deleteIdeas($idPublication, $deleteList);
            $this->insertIdeas($idPublication, $insertList);
            $connection->commit();
        } catch (Exception $e) {
            $connection->rollback();
        }
    }

    /**
     * Associate technologies with one publication
     * @param int $idTechnologies
     * @param int|Array $technologyIds
     */
    private function insertTechnologies($idPublication, array $technologyIds) {
        $statement = 'INSERT INTO Publication_involves_Technology (publication, technology) VALUES (:idPublication, :idTechnology)';
        $query = Connection::getConnection()->prepare($statement);
        
        foreach($technologyIds as $idTechnology) {
            $query->bindParam(':idPublication', $idPublication, PDO::PARAM_INT);
            $query->bindParam(':idTechnology', $idTechnology, PDO::PARAM_INT);
            $query->execute();
        }
    }

    /**
     * Disassociate technologies from one publication
     * @param int $idPublication
     * @param int|Array $technologyIds
     */
    private function deleteTechnologies($idPublication, $technologyIds = array()) {
        //init query
        $statement = 'DELETE FROM Publication_involves_Technology WHERE publication = :idPublication AND technology = :idTechnology';
        $query = Connection::getConnection()->prepare($statement);
        
        //execute on each technology
        foreach($technologyIds as $idTechnology) {
            $query->bindParam(':idPublication', $idPublication, PDO::PARAM_INT);
            $query->bindParam(':idTechnology', $idTechnology, PDO::PARAM_INT);
            $query->execute();
        }
    }

    /**
     * Update a Publication Technology list according to the object data
     * @param Publication $publication
     */
    public function updateTechnologies($publication) {
        //search existing data
        $idPublication = $publication->getId();
        $connection = Connection::getConnection();
        $statement = 'SELECT technology FROM Publication_involves_Technology WHERE publication = :idPublication';
        $query = $connection->prepare($statement);
        $query->bindParam(':idPublication', $idPublication, PDO::PARAM_INT);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_COLUMN, 0);
        $records = $query->fetchAll();
        
        //sort data to delete/insert
        $technologyIds = Utilities::getIds($publication->getTechnologys());
        
        $deleteList = array_diff($records, $technologyIds);
        $insertList = array_diff($technologyIds, $records);
        
        //delete/insert data
        $connection->beginTransaction();
        try {
            $this->deleteTechnologys($idPublication, $deleteList);
            $this->insertTechnologys($idPublication, $insertList);
            $connection->commit();
        } catch (Exception $e) {
            $connection->rollback();
        }
    }

    /**
     * Associate tags with one publication
     * @param int $idTags
     * @param int|Array $tagIds
     */
    private function insertTags($idPublication, array $tagIds) {
        $statement = 'INSERT INTO Publication_has_Tag (publication, tag) VALUES (:idPublication, :idTag)';
        $query = Connection::getConnection()->prepare($statement);
        
        foreach($tagIds as $idTag) {
            $query->bindParam(':idPublication', $idPublication, PDO::PARAM_INT);
            $query->bindParam(':idTag', $idTag, PDO::PARAM_INT);
            $query->execute();
        }
    }

    /**
     * Disassociate tags from one publication
     * @param int $idPublication
     * @param int|Array $tagIds
     */
    private function deleteTags($idPublication, $tagIds = array()) {
        //init query
        $statement = 'DELETE FROM Publication_has_Tag WHERE publication = :idPublication AND tag = :idTag';
        $query = Connection::getConnection()->prepare($statement);
        
        //execute on each tag
        foreach($tagIds as $idTag) {
            $query->bindParam(':idPublication', $idPublication, PDO::PARAM_INT);
            $query->bindParam(':idTag', $idTag, PDO::PARAM_INT);
            $query->execute();
        }
    }

    /**
     * Update a Publication Tag list according to the object data
     * @param Publication $publication
     */
    public function updateTags($publication) {
        //search existing data
        $idPublication = $publication->getId();
        $connection = Connection::getConnection();
        $statement = 'SELECT tag FROM Publication_has_Tag WHERE publication = :idPublication';
        $query = $connection->prepare($statement);
        $query->bindParam(':idPublication', $idPublication, PDO::PARAM_INT);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_COLUMN, 0);
        $records = $query->fetchAll();
        
        //sort data to delete/insert
        $tagIds = Utilities::getIds($publication->getTags());
        
        $deleteList = array_diff($records, $tagIds);
        $insertList = array_diff($tagIds, $records);
        
        //delete/insert data
        $connection->beginTransaction();
        try {
            $this->deleteTags($idPublication, $deleteList);
            $this->insertTags($idPublication, $insertList);
            $connection->commit();
        } catch (Exception $e) {
            $connection->rollback();
        }
    }

    /**
     * Update record from table Publication
     * @param Publication $publication data to update
     */
    public function update($publication) {
        //create the statement
        if ($publication->getId() == 0) throw new Exception('Impossible update on non existing object');
        $statement = 'UPDATE Publication SET title = :title, shortDescription = :shortDescription, sourcesUrl = :sourcesUrl, visits = :visits, category = :category, state = :state WHERE idPublication = :id';
        $query = Connection::getConnection()->prepare($statement);

        //bind parameters and execute query
        $id = $publication->getId();
        $title = $publication->getTitle();
        $shortDescription = $publication->getShortDescription();
        $visits = $publication->getVisits();
        $category = $publication->getCategory()->getId();
        $state = $publication->getState()->getId();

        if( !is_null( $publication->getSourcesUrl() ) )
            $sourcesUrl = $publication->getSourcesUrl();
        else
            $sourcesUrl = null;

        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->bindParam(':title', $title, PDO::PARAM_STR, 255);
        $query->bindParam(':shortDescription', $shortDescription, PDO::PARAM_STR, 255);
        $query->bindParam(':visits', $visits, PDO::PARAM_INT);
        $query->bindParam(':category', $category, PDO::PARAM_INT);
        $query->bindParam(':state', $state, PDO::PARAM_INT);

        if( is_null( $sourcesUrl ) )
            $query->bindParam(':sourcesUrl', $sourcesUrl, PDO::PARAM_NULL);
        else
            $query->bindParam(':sourcesUrl', $sourcesUrl, PDO::PARAM_STR, 255);

        $query->execute();
    }
}
