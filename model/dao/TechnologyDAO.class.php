<?php

/**
 * Description of TechnologyDAO implements DAO
 *
 * @author Jeremie FERREIRA
 */
class TechnologyDAO implements DAO {
    /**
     * Get domain object Technology by primary key
     * @param int $id primary key
     * @return Technology
     */
    public function load($id) {
        $statement = 'SELECT idTechnology AS id,name,description,technologyCategory FROM Technology WHERE idTechnology = :id';
        $query = Connection::getConnection()->prepare($statement);

        //get the first result and return it after closing the cursor
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $line = $query->fetch();
        $query->closeCursor();
        $result = Technology::parseArray($line);
        return $result;
    }

    /**
     * Select all Technology records refering to Publication
     * @return Technology|Array
     */
    public function selectByIdPublication($idPublication) {
        $result = array();
        $statement = 'SELECT idTechnology AS id, name, description, technologyCategory FROM Technology ref INNER JOIN Publication_involves_Technology asso ON ref.idTechnology = asso.technology WHERE Publication = :idPublication';
        $query = Connection::getConnection()->prepare($statement);

        //Get the results as Technology instances array and return it
        $query->bindParam(':idPublication', $idPublication, PDO::PARAM_INT);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        while($line = $query->fetch())
            $result[] = Technology::parseArray($line);
        return $result;
    }

    /**
     * Select all Technology records refering to TechnologyCategory
     * @return Technology|Array
     */
    public function selectByIdTechnologyCategory($idTechnologyCategory) {
        $result = array();
        $statement = 'SELECT idTechnology AS id, name, description, technologyCategory FROM Technology ref INNER JOIN null asso ON ref.idTechnology = asso.technology WHERE TechnologyCategory = :idTechnologyCategory';
        $query = Connection::getConnection()->prepare($statement);

        //Get the results as Technology instances array and return it
        $query->bindParam(':idTechnologyCategory', $idTechnologyCategory, PDO::PARAM_INT);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        while($line = $query->fetch())
            $result[] = Technology::parseArray($line);
        return $result;
    }

    /**
     * Get all records from table Technology
     * @return Technology|Array
     */
    public function selectAll() {
        $result = array();
        $statement = 'SELECT idTechnology AS id, name, description, technologyCategory FROM Technology';
        $query = Connection::getConnection()->prepare($statement);

        //Get the results as Technology instance array and return it
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $query->fetch())
            $result[] = Technology::parseArray($line);
        return $result;
    }

    /**
     * Get all records from table ordered by a column Technology
     * @param string $column column name
     * @return Technology|Array
     */
    public function selectAllOrderBy($column, $asc = true) {
        $result = array();
        $sorting = $asc ? ' ASC' : ' DESC';
        $statement = 'SELECT idTechnology AS id, name, description, technologyCategory FROM Technology ORDER BY '.$column.$sorting;
        $query = Connection::getConnection()->prepare($statement);
        $query->bindParam(':column', $column, PDO::PARAM_STR);
        //Get the results as Technology instance array and return it

        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        while($line = $query->fetch())
            $result[] = Technology::parseArray($line);
        return $result;
    }

    /**
     * Delete from Technology table by primary key
     * @param int $id primary key
     */
    public function delete($id) {
        $statement = 'DELETE FROM Technology WHERE idTechnology = :id';
        $query = Connection::getConnection()->prepare($statement);

        $query->bindParam(':id', $id, PDO::PARAM_INT);
        //execute query
        $query->execute(array('id' => $id));
    }

    /**
     * Insert record into table Technology
     * @param Technology $technology data to insert
     */
    public function insert($technology) {
        //create the statement
        $statement = 'INSERT INTO Technology (name, description, technologyCategory) VALUES (:name, :description, :technologyCategory)';
        $query = Connection::getConnection()->prepare($statement);

        //bind parameters and execute query
        $name = $technology->getName();
        $technologyCategory = $technology->getTechnologyCategory()->getId();

        if( !is_null( $technology->getDescription() ) )
            $description = $technology->getDescription();
        else
            $description = null;

        $query->bindParam(':name', $name, PDO::PARAM_STR, 255);
        $query->bindParam(':technologyCategory', $technologyCategory, PDO::PARAM_INT);

        if( is_null( $description ) )
            $query->bindParam(':description', $description, PDO::PARAM_NULL);
        else
            $query->bindParam(':description', $description, PDO::PARAM_STR, 1023);

        $query->execute();
    }

    /**
     * Associate publications with one technology
     * @param int $idPublications
     * @param int|Array $publicationIds
     */
    private function insertPublications($idTechnology, array $publicationIds) {
        $statement = 'INSERT INTO Publication_involves_Technology (technology, publication) VALUES (:idTechnology, :idPublication)';
        $query = Connection::getConnection()->prepare($statement);
        
        foreach($publicationIds as $idPublication) {
            $query->bindParam(':idTechnology', $idTechnology, PDO::PARAM_INT);
            $query->bindParam(':idPublication', $idPublication, PDO::PARAM_INT);
            $query->execute();
        }
    }

    /**
     * Disassociate publications from one technology
     * @param int $idTechnology
     * @param int|Array $publicationIds
     */
    private function deletePublications($idTechnology, $publicationIds = array()) {
        //init query
        $statement = 'DELETE FROM Publication_involves_Technology WHERE technology = :idTechnology AND publication = :idPublication';
        $query = Connection::getConnection()->prepare($statement);
        
        //execute on each publication
        foreach($publicationIds as $idPublication) {
            $query->bindParam(':idTechnology', $idTechnology, PDO::PARAM_INT);
            $query->bindParam(':idPublication', $idPublication, PDO::PARAM_INT);
            $query->execute();
        }
    }

    /**
     * Update a Technology Publication list according to the object data
     * @param Technology $technology
     */
    public function updatePublications($technology) {
        //search existing data
        $idTechnology = $technology->getId();
        $connection = Connection::getConnection();
        $statement = 'SELECT publication FROM Publication_involves_Technology WHERE technology = :idTechnology';
        $query = $connection->prepare($statement);
        $query->bindParam(':idTechnology', $idTechnology, PDO::PARAM_INT);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_COLUMN, 0);
        $records = $query->fetchAll();
        
        //sort data to delete/insert
        $publicationIds = Utilities::getIds($technology->getPublications());
        
        $deleteList = array_diff($records, $publicationIds);
        $insertList = array_diff($publicationIds, $records);
        
        //delete/insert data
        $connection->beginTransaction();
        try {
            $this->deletePublications($idTechnology, $deleteList);
            $this->insertPublications($idTechnology, $insertList);
            $connection->commit();
        } catch (Exception $e) {
            $connection->rollback();
        }
    }

    /**
     * Update record from table Technology
     * @param Technology $technology data to update
     */
    public function update($technology) {
        //create the statement
        if ($technology->getId() == 0) throw new Exception('Impossible update on non existing object');
        $statement = 'UPDATE Technology SET name = :name, description = :description, technologyCategory = :technologyCategory WHERE idTechnology = :id';
        $query = Connection::getConnection()->prepare($statement);

        //bind parameters and execute query
        $id = $technology->getId();
        $name = $technology->getName();
        $technologyCategory = $technology->getTechnologyCategory()->getId();

        if( !is_null( $technology->getDescription() ) )
            $description = $technology->getDescription();
        else
            $description = null;

        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->bindParam(':name', $name, PDO::PARAM_STR, 255);
        $query->bindParam(':technologyCategory', $technologyCategory, PDO::PARAM_INT);

        if( is_null( $description ) )
            $query->bindParam(':description', $description, PDO::PARAM_NULL);
        else
            $query->bindParam(':description', $description, PDO::PARAM_STR, 1023);

        $query->execute();
    }
}
