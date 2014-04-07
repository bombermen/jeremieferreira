<?php

/**
 * Description of TagDAO implements DAO
 *
 * @author Jeremie FERREIRA
 */
class TagDAO implements DAO {
    /**
     * Get domain object Tag by primary key
     * @param int $id primary key
     * @return Tag
     */
    public function load($id) {
        $statement = 'SELECT idTag AS id,name FROM Tag WHERE idTag = :id';
        $query = Connection::getConnection()->prepare($statement);

        //get the first result and return it after closing the cursor
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $line = $query->fetch();
        $query->closeCursor();
        $result = Tag::parseArray($line);
        return $result;
    }

    /**
     * Select all Tag records refering to Publication
     * @return Tag|Array
     */
    public function selectByIdPublication($idPublication) {
        $result = array();
        $statement = 'SELECT idTag AS id, name FROM Tag ref INNER JOIN Publication_has_Tag asso ON ref.idTag = asso.tag WHERE Publication = :idPublication';
        $query = Connection::getConnection()->prepare($statement);

        //Get the results as Tag instances array and return it
        $query->bindParam(':idPublication', $idPublication, PDO::PARAM_INT);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        while($line = $query->fetch())
            $result[] = Tag::parseArray($line);
        return $result;
    }

    /**
     * Get all records from table Tag
     * @return Tag|Array
     */
    public function selectAll() {
        $result = array();
        $statement = 'SELECT idTag AS id, name FROM Tag';
        $query = Connection::getConnection()->prepare($statement);

        //Get the results as Tag instance array and return it
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $query->fetch())
            $result[] = Tag::parseArray($line);
        return $result;
    }

    /**
     * Get all records from table ordered by a column Tag
     * @param string $column column name
     * @return Tag|Array
     */
    public function selectAllOrderBy($column, $asc = true) {
        $result = array();
        $sorting = $asc ? ' ASC' : ' DESC';
        $statement = 'SELECT idTag AS id, name FROM Tag ORDER BY '.$column.$sorting;
        $query = Connection::getConnection()->prepare($statement);
        $query->bindParam(':column', $column, PDO::PARAM_STR);
        //Get the results as Tag instance array and return it

        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        while($line = $query->fetch())
            $result[] = Tag::parseArray($line);
        return $result;
    }

    /**
     * Delete from Tag table by primary key
     * @param int $id primary key
     */
    public function delete($id) {
        $statement = 'DELETE FROM Tag WHERE idTag = :id';
        $query = Connection::getConnection()->prepare($statement);

        $query->bindParam(':id', $id, PDO::PARAM_INT);
        //execute query
        $query->execute(array('id' => $id));
    }

    /**
     * Insert record into table Tag
     * @param Tag $tag data to insert
     */
    public function insert($tag) {
        //create the statement
        $statement = 'INSERT INTO Tag (name) VALUES (:name)';
        $query = Connection::getConnection()->prepare($statement);

        //bind parameters and execute query
        $name = $tag->getName();


        $query->bindParam(':name', $name, PDO::PARAM_STR, 255);


        $query->execute();
    }

    /**
     * Associate publications with one tag
     * @param int $idPublications
     * @param int|Array $publicationIds
     */
    private function insertPublications($idTag, array $publicationIds) {
        $statement = 'INSERT INTO Publication_has_Tag (tag, publication) VALUES (:idTag, :idPublication)';
        $query = Connection::getConnection()->prepare($statement);
        
        foreach($publicationIds as $idPublication) {
            $query->bindParam(':idTag', $idTag, PDO::PARAM_INT);
            $query->bindParam(':idPublication', $idPublication, PDO::PARAM_INT);
            $query->execute();
        }
    }

    /**
     * Disassociate publications from one tag
     * @param int $idTag
     * @param int|Array $publicationIds
     */
    private function deletePublications($idTag, $publicationIds = array()) {
        //init query
        $statement = 'DELETE FROM Publication_has_Tag WHERE tag = :idTag AND publication = :idPublication';
        $query = Connection::getConnection()->prepare($statement);
        
        //execute on each publication
        foreach($publicationIds as $idPublication) {
            $query->bindParam(':idTag', $idTag, PDO::PARAM_INT);
            $query->bindParam(':idPublication', $idPublication, PDO::PARAM_INT);
            $query->execute();
        }
    }

    /**
     * Update a Tag Publication list according to the object data
     * @param Tag $tag
     */
    public function updatePublications($tag) {
        //search existing data
        $idTag = $tag->getId();
        $connection = Connection::getConnection();
        $statement = 'SELECT publication FROM Publication_has_Tag WHERE tag = :idTag';
        $query = $connection->prepare($statement);
        $query->bindParam(':idTag', $idTag, PDO::PARAM_INT);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_COLUMN, 0);
        $records = $query->fetchAll();
        
        //sort data to delete/insert
        $publicationIds = Utilities::getIds($tag->getPublications());
        
        $deleteList = array_diff($records, $publicationIds);
        $insertList = array_diff($publicationIds, $records);
        
        //delete/insert data
        $connection->beginTransaction();
        try {
            $this->deletePublications($idTag, $deleteList);
            $this->insertPublications($idTag, $insertList);
            $connection->commit();
        } catch (Exception $e) {
            $connection->rollback();
        }
    }

    /**
     * Update record from table Tag
     * @param Tag $tag data to update
     */
    public function update($tag) {
        //create the statement
        if ($tag->getId() == 0) throw new Exception('Impossible update on non existing object');
        $statement = 'UPDATE Tag SET name = :name WHERE idTag = :id';
        $query = Connection::getConnection()->prepare($statement);

        //bind parameters and execute query
        $id = $tag->getId();
        $name = $tag->getName();


        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->bindParam(':name', $name, PDO::PARAM_STR, 255);


        $query->execute();
    }
}
