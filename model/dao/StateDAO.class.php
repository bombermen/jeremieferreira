<?php

/**
 * Description of StateDAO implements DAO
 *
 * @author Jeremie FERREIRA
 */
class StateDAO implements DAO {
    /**
     * Get domain object State by primary key
     * @param int $id primary key
     * @return State
     */
    public function load($id) {
        $statement = 'SELECT idState AS id,name FROM State WHERE idState = :id';
        $query = Connection::getConnection()->prepare($statement);

        //get the first result and return it after closing the cursor
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $line = $query->fetch();
        $query->closeCursor();
        $result = State::parseArray($line);
        return $result;
    }

    /**
     * Select all State records refering to Publication
     * @return State|Array
     */
    public function selectByIdPublication($idPublication) {
        $result = array();
        $statement = 'SELECT idState AS id, name FROM State ref INNER JOIN null asso ON ref.idState = asso.state WHERE Publication = :idPublication';
        $query = Connection::getConnection()->prepare($statement);

        //Get the results as State instances array and return it
        $query->bindParam(':idPublication', $idPublication, PDO::PARAM_INT);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        while($line = $query->fetch())
            $result[] = State::parseArray($line);
        return $result;
    }

    /**
     * Get all records from table State
     * @return State|Array
     */
    public function selectAll() {
        $result = array();
        $statement = 'SELECT idState AS id, name FROM State';
        $query = Connection::getConnection()->prepare($statement);

        //Get the results as State instance array and return it
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $query->fetch())
            $result[] = State::parseArray($line);
        return $result;
    }

    /**
     * Get all records from table ordered by a column State
     * @param string $column column name
     * @return State|Array
     */
    public function selectAllOrderBy($column, $asc = true) {
        $result = array();
        $sorting = $asc ? ' ASC' : ' DESC';
        $statement = 'SELECT idState AS id, name FROM State ORDER BY '.$column.$sorting;
        $query = Connection::getConnection()->prepare($statement);
        $query->bindParam(':column', $column, PDO::PARAM_STR);
        //Get the results as State instance array and return it

        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        while($line = $query->fetch())
            $result[] = State::parseArray($line);
        return $result;
    }

    /**
     * Delete from State table by primary key
     * @param int $id primary key
     */
    public function delete($id) {
        $statement = 'DELETE FROM State WHERE idState = :id';
        $query = Connection::getConnection()->prepare($statement);

        $query->bindParam(':id', $id, PDO::PARAM_INT);
        //execute query
        $query->execute(array('id' => $id));
    }

    /**
     * Insert record into table State
     * @param State $state data to insert
     */
    public function insert($state) {
        //create the statement
        $statement = 'INSERT INTO State (name) VALUES (:name)';
        $query = Connection::getConnection()->prepare($statement);

        //bind parameters and execute query
        $name = $state->getName();


        $query->bindParam(':name', $name, PDO::PARAM_STR, 255);


        $query->execute();
    }

    /**
     * Update record from table State
     * @param State $state data to update
     */
    public function update($state) {
        //create the statement
        if ($state->getId() == 0) throw new Exception('Impossible update on non existing object');
        $statement = 'UPDATE State SET name = :name WHERE idState = :id';
        $query = Connection::getConnection()->prepare($statement);

        //bind parameters and execute query
        $id = $state->getId();
        $name = $state->getName();


        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->bindParam(':name', $name, PDO::PARAM_STR, 255);


        $query->execute();
    }
}
