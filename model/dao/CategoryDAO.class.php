<?php

/**
 * Description of CategoryDAO implements DAO
 *
 * @author Jeremie FERREIRA
 */
class CategoryDAO implements DAO {
    /**
     * Get domain object Category by primary key
     * @param int $id primary key
     * @return Category
     */
    public function load($id) {
        $statement = 'SELECT idCategory AS id,name,description,visible,parent FROM Category WHERE idCategory = :id';
        $query = Connection::getConnection()->prepare($statement);

        //get the first result and return it after closing the cursor
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $line = $query->fetch();
        $query->closeCursor();
        $result = Category::parseArray($line);
        return $result;
    }

    /**
    * Load children
    * @param int $id
    * @return Category
    */
    public function loadChildren($id) {
        $result = array();
        $statement = 'SELECT idCategory AS id, name, description, visible, parent FROM Category WHERE parent = :id';
        $query = Connection::getConnection()->prepare($statement);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $query->fetch()) {
            $result[] = $line;
        }
        return $result;
    }

    /**
     * Select all Category records refering to Publication
     * @return Category|Array
     */
    public function selectByIdPublication($idPublication) {
        $result = array();
        $statement = 'SELECT idCategory AS id, name, description, visible, parent FROM Category ref INNER JOIN null asso ON ref.idCategory = asso.category WHERE Publication = :idPublication';
        $query = Connection::getConnection()->prepare($statement);

        //Get the results as Category instances array and return it
        $query->bindParam(':idPublication', $idPublication, PDO::PARAM_INT);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        while($line = $query->fetch())
            $result[] = Category::parseArray($line);
        return $result;
    }

    /**
     * Get all records from table Category
     * @return Category|Array
     */
    public function selectAll() {
        $result = array();
        $statement = 'SELECT idCategory AS id, name, description, visible, parent FROM Category';
        $query = Connection::getConnection()->prepare($statement);

        //Get the results as Category instance array and return it
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $query->fetch())
            $result[] = Category::parseArray($line);
        return $result;
    }

    /**
     * Get all records from table ordered by a column Category
     * @param string $column column name
     * @return Category|Array
     */
    public function selectAllOrderBy($column, $asc = true) {
        $result = array();
        $sorting = $asc ? ' ASC' : ' DESC';
        $statement = 'SELECT idCategory AS id, name, description, visible, parent FROM Category ORDER BY '.$column.$sorting;
        $query = Connection::getConnection()->prepare($statement);
        $query->bindParam(':column', $column, PDO::PARAM_STR);
        //Get the results as Category instance array and return it

        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        while($line = $query->fetch())
            $result[] = Category::parseArray($line);
        return $result;
    }

    /**
     * Delete from Category table by primary key
     * @param int $id primary key
     */
    public function delete($id) {
        $statement = 'DELETE FROM Category WHERE idCategory = :id';
        $query = Connection::getConnection()->prepare($statement);

        $query->bindParam(':id', $id, PDO::PARAM_INT);
        //execute query
        $query->execute(array('id' => $id));
    }

    /**
     * Insert record into table Category
     * @param Category $category data to insert
     */
    public function insert($category) {
        //create the statement
        $statement = 'INSERT INTO Category (name, description, visible, parent) VALUES (:name, :description, :visible, :parent)';
        $query = Connection::getConnection()->prepare($statement);

        //bind parameters and execute query
        $name = $category->getName();
        $visible = $category->getVisible();

        if( !is_null( $category->getDescription() ) )
            $description = $category->getDescription();
        else
            $description = null;
        if( !is_null( $category->getParent() ) )
            $parent = $category->getParent()->getId();
        else
            $parent = null;

        $query->bindParam(':name', $name, PDO::PARAM_STR, 255);
        $query->bindParam(':visible', $visible, PDO::PARAM_INT);

        if( is_null( $description ) )
            $query->bindParam(':description', $description, PDO::PARAM_NULL);
        else
            $query->bindParam(':description', $description, PDO::PARAM_STR, 511);
        if( is_null( $parent ) )
            $query->bindParam(':parent', $parent, PDO::PARAM_NULL);
        else
            $query->bindParam(':parent', $parent, PDO::PARAM_INT);

        $query->execute();
    }

    /**
     * Update record from table Category
     * @param Category $category data to update
     */
    public function update($category) {
        //create the statement
        if ($category->getId() == 0) throw new Exception('Impossible update on non existing object');
        $statement = 'UPDATE Category SET name = :name, description = :description, visible = :visible, parent = :parent WHERE idCategory = :id';
        $query = Connection::getConnection()->prepare($statement);

        //bind parameters and execute query
        $id = $category->getId();
        $name = $category->getName();
        $visible = $category->getVisible();

        if( !is_null( $category->getDescription() ) )
            $description = $category->getDescription();
        else
            $description = null;
        if( !is_null( $category->getParent() ) )
            $parent = $category->getParent()->getId();
        else
            $parent = null;

        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->bindParam(':name', $name, PDO::PARAM_STR, 255);
        $query->bindParam(':visible', $visible, PDO::PARAM_INT);

        if( is_null( $description ) )
            $query->bindParam(':description', $description, PDO::PARAM_NULL);
        else
            $query->bindParam(':description', $description, PDO::PARAM_STR, 511);
        if( is_null( $parent ) )
            $query->bindParam(':parent', $parent, PDO::PARAM_NULL);
        else
            $query->bindParam(':parent', $parent, PDO::PARAM_INT);

        $query->execute();
    }
}
