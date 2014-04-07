<?php

/**
 * Description of DidYouKnowDAO implements DAO
 *
 * @author Jeremie FERREIRA
 */
class DidYouKnowDAO implements DAO {
    /**
     * Get domain object DidYouKnow by primary key
     * @param int $id primary key
     * @return DidYouKnow
     */
    public function load($id) {
        $statement = 'SELECT idDidYouKnow AS id,knowledge FROM DidYouKnow WHERE idDidYouKnow = :id';
        $query = Connection::getConnection()->prepare($statement);

        //get the first result and return it after closing the cursor
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $line = $query->fetch();
        $query->closeCursor();
        $result = DidYouKnow::parseArray($line);
        return $result;
    }

    /**
     * Get all records from table DidYouKnow
     * @return DidYouKnow|Array
     */
    public function selectAll() {
        $result = array();
        $statement = 'SELECT idDidYouKnow AS id, knowledge FROM DidYouKnow';
        $query = Connection::getConnection()->prepare($statement);

        //Get the results as DidYouKnow instance array and return it
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $query->fetch())
            $result[] = DidYouKnow::parseArray($line);
        return $result;
    }

    /**
     * Get all records from table ordered by a column DidYouKnow
     * @param string $column column name
     * @return DidYouKnow|Array
     */
    public function selectAllOrderBy($column, $asc = true) {
        $result = array();
        $sorting = $asc ? ' ASC' : ' DESC';
        $statement = 'SELECT idDidYouKnow AS id, knowledge FROM DidYouKnow ORDER BY '.$column.$sorting;
        $query = Connection::getConnection()->prepare($statement);
        $query->bindParam(':column', $column, PDO::PARAM_STR);
        //Get the results as DidYouKnow instance array and return it

        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        while($line = $query->fetch())
            $result[] = DidYouKnow::parseArray($line);
        return $result;
    }

    /**
     * Delete from DidYouKnow table by primary key
     * @param int $id primary key
     */
    public function delete($id) {
        $statement = 'DELETE FROM DidYouKnow WHERE idDidYouKnow = :id';
        $query = Connection::getConnection()->prepare($statement);

        $query->bindParam(':id', $id, PDO::PARAM_INT);
        //execute query
        $query->execute(array('id' => $id));
    }

    /**
     * Insert record into table DidYouKnow
     * @param DidYouKnow $didYouKnow data to insert
     */
    public function insert($didYouKnow) {
        //create the statement
        $statement = 'INSERT INTO DidYouKnow (knowledge) VALUES (:knowledge)';
        $query = Connection::getConnection()->prepare($statement);

        //bind parameters and execute query
        $knowledge = $didYouKnow->getKnowledge();


        $query->bindParam(':knowledge', $knowledge, PDO::PARAM_STR, 255);


        $query->execute();
    }

    /**
     * Update record from table DidYouKnow
     * @param DidYouKnow $didYouKnow data to update
     */
    public function update($didYouKnow) {
        //create the statement
        if ($didYouKnow->getId() == 0) throw new Exception('Impossible update on non existing object');
        $statement = 'UPDATE DidYouKnow SET knowledge = :knowledge WHERE idDidYouKnow = :id';
        $query = Connection::getConnection()->prepare($statement);

        //bind parameters and execute query
        $id = $didYouKnow->getId();
        $knowledge = $didYouKnow->getKnowledge();


        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->bindParam(':knowledge', $knowledge, PDO::PARAM_STR, 255);


        $query->execute();
    }
}
