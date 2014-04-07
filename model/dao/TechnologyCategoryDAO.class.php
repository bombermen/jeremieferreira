<?php

/**
 * Description of TechnologyCategoryDAO implements DAO
 *
 * @author Jeremie FERREIRA
 */
class TechnologyCategoryDAO implements DAO {
    /**
     * Get domain object TechnologyCategory by primary key
     * @param int $id primary key
     * @return TechnologyCategory
     */
    public function load($id) {
        $statement = 'SELECT idTechnologyCategory AS id,name,visible,description FROM TechnologyCategory WHERE idTechnologyCategory = :id';
        $query = Connection::getConnection()->prepare($statement);

        //get the first result and return it after closing the cursor
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $line = $query->fetch();
        $query->closeCursor();
        $result = TechnologyCategory::parseArray($line);
        return $result;
    }

    /**
     * Select all TechnologyCategory records refering to Technology
     * @return TechnologyCategory|Array
     */
    public function selectByIdTechnology($idTechnology) {
        $result = array();
        $statement = 'SELECT idTechnologyCategory AS id, name, visible, description FROM TechnologyCategory ref INNER JOIN null asso ON ref.idTechnologyCategory = asso.technologyCategory WHERE Technology = :idTechnology';
        $query = Connection::getConnection()->prepare($statement);

        //Get the results as TechnologyCategory instances array and return it
        $query->bindParam(':idTechnology', $idTechnology, PDO::PARAM_INT);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        while($line = $query->fetch())
            $result[] = TechnologyCategory::parseArray($line);
        return $result;
    }

    /**
     * Get all records from table TechnologyCategory
     * @return TechnologyCategory|Array
     */
    public function selectAll() {
        $result = array();
        $statement = 'SELECT idTechnologyCategory AS id, name, visible, description FROM TechnologyCategory';
        $query = Connection::getConnection()->prepare($statement);

        //Get the results as TechnologyCategory instance array and return it
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $query->fetch())
            $result[] = TechnologyCategory::parseArray($line);
        return $result;
    }

    /**
     * Get all records from table ordered by a column TechnologyCategory
     * @param string $column column name
     * @return TechnologyCategory|Array
     */
    public function selectAllOrderBy($column, $asc = true) {
        $result = array();
        $sorting = $asc ? ' ASC' : ' DESC';
        $statement = 'SELECT idTechnologyCategory AS id, name, visible, description FROM TechnologyCategory ORDER BY '.$column.$sorting;
        $query = Connection::getConnection()->prepare($statement);
        $query->bindParam(':column', $column, PDO::PARAM_STR);
        //Get the results as TechnologyCategory instance array and return it

        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        while($line = $query->fetch())
            $result[] = TechnologyCategory::parseArray($line);
        return $result;
    }

    /**
     * Delete from TechnologyCategory table by primary key
     * @param int $id primary key
     */
    public function delete($id) {
        $statement = 'DELETE FROM TechnologyCategory WHERE idTechnologyCategory = :id';
        $query = Connection::getConnection()->prepare($statement);

        $query->bindParam(':id', $id, PDO::PARAM_INT);
        //execute query
        $query->execute(array('id' => $id));
    }

    /**
     * Insert record into table TechnologyCategory
     * @param TechnologyCategory $technologyCategory data to insert
     */
    public function insert($technologyCategory) {
        //create the statement
        $statement = 'INSERT INTO TechnologyCategory (name, visible, description) VALUES (:name, :visible, :description)';
        $query = Connection::getConnection()->prepare($statement);

        //bind parameters and execute query
        $name = $technologyCategory->getName();
        $visible = $technologyCategory->getVisible();

        if( !is_null( $technologyCategory->getDescription() ) )
            $description = $technologyCategory->getDescription();
        else
            $description = null;

        $query->bindParam(':name', $name, PDO::PARAM_STR, 255);
        $query->bindParam(':visible', $visible, PDO::PARAM_INT);

        if( is_null( $description ) )
            $query->bindParam(':description', $description, PDO::PARAM_NULL);
        else
            $query->bindParam(':description', $description, PDO::PARAM_STR, 511);

        $query->execute();
    }

    /**
     * Update record from table TechnologyCategory
     * @param TechnologyCategory $technologyCategory data to update
     */
    public function update($technologyCategory) {
        //create the statement
        if ($technologyCategory->getId() == 0) throw new Exception('Impossible update on non existing object');
        $statement = 'UPDATE TechnologyCategory SET name = :name, visible = :visible, description = :description WHERE idTechnologyCategory = :id';
        $query = Connection::getConnection()->prepare($statement);

        //bind parameters and execute query
        $id = $technologyCategory->getId();
        $name = $technologyCategory->getName();
        $visible = $technologyCategory->getVisible();

        if( !is_null( $technologyCategory->getDescription() ) )
            $description = $technologyCategory->getDescription();
        else
            $description = null;

        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->bindParam(':name', $name, PDO::PARAM_STR, 255);
        $query->bindParam(':visible', $visible, PDO::PARAM_INT);

        if( is_null( $description ) )
            $query->bindParam(':description', $description, PDO::PARAM_NULL);
        else
            $query->bindParam(':description', $description, PDO::PARAM_STR, 511);

        $query->execute();
    }
}
