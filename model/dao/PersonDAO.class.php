<?php

/**
 * Description of PersonDAO implements DAO
 *
 * @author Jeremie FERREIRA
 */
class PersonDAO implements DAO {
    /**
     * Get domain object Person by primary key
     * @param int $id primary key
     * @return Person
     */
    public function load($id) {
        $statement = 'SELECT idPerson AS id,name,surname,UNIX_TIMESTAMP(birthdate) AS birthdate,website,email FROM Person WHERE idPerson = :id';
        $query = Connection::getConnection()->prepare($statement);

        //get the first result and return it after closing the cursor
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $line = $query->fetch();
        $query->closeCursor();
        $result = Person::parseArray($line);
        return $result;
    }

    /**
     * Select all Person records refering to Publication
     * @return Person|Array
     */
    public function selectByIdPublication($idPublication) {
        $result = array();
        $statement = 'SELECT idPerson AS id, name, surname, UNIX_TIMESTAMP(birthdate) AS birthdate, website, email FROM Person ref INNER JOIN Person_collaboratesTo_Publication asso ON ref.idPerson = asso.person WHERE Publication = :idPublication';
        $query = Connection::getConnection()->prepare($statement);

        //Get the results as Person instances array and return it
        $query->bindParam(':idPublication', $idPublication, PDO::PARAM_INT);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        while($line = $query->fetch())
            $result[] = Person::parseArray($line);
        return $result;
    }

    /**
     * Get all records from table Person
     * @return Person|Array
     */
    public function selectAll() {
        $result = array();
        $statement = 'SELECT idPerson AS id, name, surname, UNIX_TIMESTAMP(birthdate) AS birthdate, website, email FROM Person';
        $query = Connection::getConnection()->prepare($statement);

        //Get the results as Person instance array and return it
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $query->fetch())
            $result[] = Person::parseArray($line);
        return $result;
    }

    /**
     * Get all records from table ordered by a column Person
     * @param string $column column name
     * @return Person|Array
     */
    public function selectAllOrderBy($column, $asc = true) {
        $result = array();
        $sorting = $asc ? ' ASC' : ' DESC';
        $statement = 'SELECT idPerson AS id, name, surname, UNIX_TIMESTAMP(birthdate) AS birthdate, website, email FROM Person ORDER BY '.$column.$sorting;
        $query = Connection::getConnection()->prepare($statement);
        $query->bindParam(':column', $column, PDO::PARAM_STR);
        //Get the results as Person instance array and return it

        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        while($line = $query->fetch())
            $result[] = Person::parseArray($line);
        return $result;
    }

    /**
     * Delete from Person table by primary key
     * @param int $id primary key
     */
    public function delete($id) {
        $statement = 'DELETE FROM Person WHERE idPerson = :id';
        $query = Connection::getConnection()->prepare($statement);

        $query->bindParam(':id', $id, PDO::PARAM_INT);
        //execute query
        $query->execute(array('id' => $id));
    }

    /**
     * Insert record into table Person
     * @param Person $person data to insert
     */
    public function insert($person) {
        //create the statement
        $statement = 'INSERT INTO Person (name, surname, birthdate, website, email) VALUES (:name, :surname, FROM_UNIXTIME(:birthdate), :website, :email)';
        $query = Connection::getConnection()->prepare($statement);

        //bind parameters and execute query
        $name = $person->getName();
        $surname = $person->getSurname();
        $birthdate = $person->getBirthdate()->getTimestamp();

        if( !is_null( $person->getWebsite() ) )
            $website = $person->getWebsite();
        else
            $website = null;
        if( !is_null( $person->getEmail() ) )
            $email = $person->getEmail();
        else
            $email = null;

        $query->bindParam(':name', $name, PDO::PARAM_STR, 255);
        $query->bindParam(':surname', $surname, PDO::PARAM_STR, 255);
        $query->bindParam(':birthdate', $birthdate, PDO::PARAM_INT);

        if( is_null( $website ) )
            $query->bindParam(':website', $website, PDO::PARAM_NULL);
        else
            $query->bindParam(':website', $website, PDO::PARAM_STR, 255);
        if( is_null( $email ) )
            $query->bindParam(':email', $email, PDO::PARAM_NULL);
        else
            $query->bindParam(':email', $email, PDO::PARAM_STR, 255);

        $query->execute();
    }

    /**
     * Associate publications with one person
     * @param int $idPublications
     * @param int|Array $publicationIds
     */
    private function insertPublications($idPerson, array $publicationIds) {
        $statement = 'INSERT INTO Person_collaboratesTo_Publication (person, publication) VALUES (:idPerson, :idPublication)';
        $query = Connection::getConnection()->prepare($statement);
        
        foreach($publicationIds as $idPublication) {
            $query->bindParam(':idPerson', $idPerson, PDO::PARAM_INT);
            $query->bindParam(':idPublication', $idPublication, PDO::PARAM_INT);
            $query->execute();
        }
    }

    /**
     * Disassociate publications from one person
     * @param int $idPerson
     * @param int|Array $publicationIds
     */
    private function deletePublications($idPerson, $publicationIds = array()) {
        //init query
        $statement = 'DELETE FROM Person_collaboratesTo_Publication WHERE person = :idPerson AND publication = :idPublication';
        $query = Connection::getConnection()->prepare($statement);
        
        //execute on each publication
        foreach($publicationIds as $idPublication) {
            $query->bindParam(':idPerson', $idPerson, PDO::PARAM_INT);
            $query->bindParam(':idPublication', $idPublication, PDO::PARAM_INT);
            $query->execute();
        }
    }

    /**
     * Update a Person Publication list according to the object data
     * @param Person $person
     */
    public function updatePublications($person) {
        //search existing data
        $idPerson = $person->getId();
        $connection = Connection::getConnection();
        $statement = 'SELECT publication FROM Person_collaboratesTo_Publication WHERE person = :idPerson';
        $query = $connection->prepare($statement);
        $query->bindParam(':idPerson', $idPerson, PDO::PARAM_INT);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_COLUMN, 0);
        $records = $query->fetchAll();
        
        //sort data to delete/insert
        $publicationIds = Utilities::getIds($person->getPublications());
        
        $deleteList = array_diff($records, $publicationIds);
        $insertList = array_diff($publicationIds, $records);
        
        //delete/insert data
        $connection->beginTransaction();
        try {
            $this->deletePublications($idPerson, $deleteList);
            $this->insertPublications($idPerson, $insertList);
            $connection->commit();
        } catch (Exception $e) {
            $connection->rollback();
        }
    }

    /**
     * Update record from table Person
     * @param Person $person data to update
     */
    public function update($person) {
        //create the statement
        if ($person->getId() == 0) throw new Exception('Impossible update on non existing object');
        $statement = 'UPDATE Person SET name = :name, surname = :surname, birthdate = FROM_UNIXTIME(:birthdate), website = :website, email = :email WHERE idPerson = :id';
        $query = Connection::getConnection()->prepare($statement);

        //bind parameters and execute query
        $id = $person->getId();
        $name = $person->getName();
        $surname = $person->getSurname();
        $birthdate = $person->getBirthdate();

        if( !is_null( $person->getWebsite() ) )
            $website = $person->getWebsite();
        else
            $website = null;
        if( !is_null( $person->getEmail() ) )
            $email = $person->getEmail();
        else
            $email = null;

        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->bindParam(':name', $name, PDO::PARAM_STR, 255);
        $query->bindParam(':surname', $surname, PDO::PARAM_STR, 255);
        $query->bindParam(':birthdate', $birthdate, PDO::PARAM_INT);

        if( is_null( $website ) )
            $query->bindParam(':website', $website, PDO::PARAM_NULL);
        else
            $query->bindParam(':website', $website, PDO::PARAM_STR, 255);
        if( is_null( $email ) )
            $query->bindParam(':email', $email, PDO::PARAM_NULL);
        else
            $query->bindParam(':email', $email, PDO::PARAM_STR, 255);

        $query->execute();
    }
}
