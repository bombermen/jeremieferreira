<?php

/**
 * Description of IdeaDAO implements DAO
 *
 * @author Jeremie FERREIRA
 */
class IdeaDAO implements DAO {
    /**
     * Get domain object Idea by primary key
     * @param int $id primary key
     * @return Idea
     */
    public function load($id) {
        $statement = 'SELECT idIdea AS id,UNIX_TIMESTAMP(postDate) AS postDate FROM Idea WHERE idIdea = :id';
        $query = Connection::getConnection()->prepare($statement);

        //get the first result and return it after closing the cursor
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $line = $query->fetch();
        $query->closeCursor();
        $result = Idea::parseArray($line);
        return $result;
    }

    /**
     * Select all Idea records refering to Publication
     * @return Idea|Array
     */
    public function selectByIdPublication($idPublication) {
        $result = array();
        $statement = 'SELECT idIdea AS id, UNIX_TIMESTAMP(postDate) AS postDate FROM Idea ref INNER JOIN Idea_inspired_Publication asso ON ref.idIdea = asso.idea WHERE Publication = :idPublication';
        $query = Connection::getConnection()->prepare($statement);

        //Get the results as Idea instances array and return it
        $query->bindParam(':idPublication', $idPublication, PDO::PARAM_INT);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        while($line = $query->fetch())
            $result[] = Idea::parseArray($line);
        return $result;
    }

    /**
     * Get all records from table Idea
     * @return Idea|Array
     */
    public function selectAll() {
        $result = array();
        $statement = 'SELECT idIdea AS id, UNIX_TIMESTAMP(postDate) AS postDate FROM Idea';
        $query = Connection::getConnection()->prepare($statement);

        //Get the results as Idea instance array and return it
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $query->fetch())
            $result[] = Idea::parseArray($line);
        return $result;
    }

    /**
     * Get all records from table ordered by a column Idea
     * @param string $column column name
     * @return Idea|Array
     */
    public function selectAllOrderBy($column, $asc = true) {
        $result = array();
        $sorting = $asc ? ' ASC' : ' DESC';
        $statement = 'SELECT idIdea AS id, UNIX_TIMESTAMP(postDate) AS postDate FROM Idea ORDER BY '.$column.$sorting;
        $query = Connection::getConnection()->prepare($statement);
        $query->bindParam(':column', $column, PDO::PARAM_STR);
        //Get the results as Idea instance array and return it

        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        while($line = $query->fetch())
            $result[] = Idea::parseArray($line);
        return $result;
    }

    /**
     * Delete from Idea table by primary key
     * @param int $id primary key
     */
    public function delete($id) {
        $statement = 'DELETE FROM Idea WHERE idIdea = :id';
        $query = Connection::getConnection()->prepare($statement);

        $query->bindParam(':id', $id, PDO::PARAM_INT);
        //execute query
        $query->execute(array('id' => $id));
    }

    /**
     * Insert record into table Idea
     * @param Idea $idea data to insert
     */
    public function insert($idea) {
        //create the statement
        $statement = 'INSERT INTO Idea (postDate) VALUES (FROM_UNIXTIME(:postDate))';
        $query = Connection::getConnection()->prepare($statement);

        //bind parameters and execute query
        $postDate = $idea->getPostDate()->getTimestamp();


        $query->bindParam(':postDate', $postDate, PDO::PARAM_INT);


        $query->execute();
    }

    /**
     * Associate publications with one idea
     * @param int $idPublications
     * @param int|Array $publicationIds
     */
    private function insertPublications($idIdea, array $publicationIds) {
        $statement = 'INSERT INTO Idea_inspired_Publication (idea, publication) VALUES (:idIdea, :idPublication)';
        $query = Connection::getConnection()->prepare($statement);
        
        foreach($publicationIds as $idPublication) {
            $query->bindParam(':idIdea', $idIdea, PDO::PARAM_INT);
            $query->bindParam(':idPublication', $idPublication, PDO::PARAM_INT);
            $query->execute();
        }
    }

    /**
     * Disassociate publications from one idea
     * @param int $idIdea
     * @param int|Array $publicationIds
     */
    private function deletePublications($idIdea, $publicationIds = array()) {
        //init query
        $statement = 'DELETE FROM Idea_inspired_Publication WHERE idea = :idIdea AND publication = :idPublication';
        $query = Connection::getConnection()->prepare($statement);
        
        //execute on each publication
        foreach($publicationIds as $idPublication) {
            $query->bindParam(':idIdea', $idIdea, PDO::PARAM_INT);
            $query->bindParam(':idPublication', $idPublication, PDO::PARAM_INT);
            $query->execute();
        }
    }

    /**
     * Update a Idea Publication list according to the object data
     * @param Idea $idea
     */
    public function updatePublications($idea) {
        //search existing data
        $idIdea = $idea->getId();
        $connection = Connection::getConnection();
        $statement = 'SELECT publication FROM Idea_inspired_Publication WHERE idea = :idIdea';
        $query = $connection->prepare($statement);
        $query->bindParam(':idIdea', $idIdea, PDO::PARAM_INT);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_COLUMN, 0);
        $records = $query->fetchAll();
        
        //sort data to delete/insert
        $publicationIds = Utilities::getIds($idea->getPublications());
        
        $deleteList = array_diff($records, $publicationIds);
        $insertList = array_diff($publicationIds, $records);
        
        //delete/insert data
        $connection->beginTransaction();
        try {
            $this->deletePublications($idIdea, $deleteList);
            $this->insertPublications($idIdea, $insertList);
            $connection->commit();
        } catch (Exception $e) {
            $connection->rollback();
        }
    }

    /**
     * Update record from table Idea
     * @param Idea $idea data to update
     */
    public function update($idea) {
        //create the statement
        if ($idea->getId() == 0) throw new Exception('Impossible update on non existing object');
        $statement = 'UPDATE Idea SET postDate = FROM_UNIXTIME(:postDate) WHERE idIdea = :id';
        $query = Connection::getConnection()->prepare($statement);

        //bind parameters and execute query
        $id = $idea->getId();
        $postDate = $idea->getPostDate();


        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->bindParam(':postDate', $postDate, PDO::PARAM_INT);


        $query->execute();
    }
}
