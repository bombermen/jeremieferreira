<?php

/**
 * Description of CategoryDAOImpl implements CategoryDAO
 *
 * @author Jeremie FERREIRA
 */
class CategoryDAOImpl implements CategoryDAO {
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
    private $_selectByIdCategoryStatement;

    /*
     * @var PDOStatement
     */
    private $_deleteCategoryChildrenStatement;

    /*
     * @var PDOStatement
     */
    private $_insertCategoryChildrenStatement;

    /*
     * @var PDOStatement
     */
    private $_selectByIdPublicationStatement;

    /*
     * @var PDOStatement
     */
    private $_deleteCategoryPublicationsStatement;

    /*
     * @var PDOStatement
     */
    private $_insertCategoryPublicationsStatement;

    /**
     * Get domain object Category by primary key
     * @param int $id primary key
     * @return Category
     */
    public function load($id) {
        //initialize the prepared statement if it is not
        if(!isset($this->_loadStatement)) {
            $statement = 'SELECT idCategory AS id, name, abstract FROM Category WHERE idCategory = :id';
            $this->_loadStatement = Connection::getConnection()->prepare($statement);
        }

        //get the first result and return it after closing the cursor
        $this->_loadStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->_loadStatement->execute(array('id' => $id));
        $line = $this->_loadStatement->fetch();
        $this->_loadStatement->closeCursor();
        $result = new Category($line);
        return $result;
    }

    /**
     * Select all Category records refering to Category
     * @return Category|Array
     */
    public function selectByIdCategory($idCategory) {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllStatement)) {
            $statement = 'SELECT idCategory AS id, name, abstract FROM Category NATURAL JOIN Category WHERE idCategory = :idCategory';
            $this->_selectByIdCategoryStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as Category instances array and return it
        $this->_selectByIdCategoryStatement->execute(array('idCategory' => $idCategory));
        $this->_selectByIdCategoryStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectByIdCategoryStatement->fetch())
            $result[] = new Category($line);
        return $result;
    }

    /**
     * Select all Category records refering to Publication
     * @return Category|Array
     */
    public function selectByIdPublication($idPublication) {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllStatement)) {
            $statement = 'SELECT idCategory AS id, name, abstract FROM Category NATURAL JOIN Publication WHERE idPublication = :idPublication';
            $this->_selectByIdPublicationStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as Category instances array and return it
        $this->_selectByIdPublicationStatement->execute(array('idPublication' => $idPublication));
        $this->_selectByIdPublicationStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectByIdPublicationStatement->fetch())
            $result[] = new Category($line);
        return $result;
    }

    /**
     * Get all records from table Category
     * @return Category|Array
     */
    public function selectAll() {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllStatement)) {
            $statement = 'SELECT idCategory AS id, name, abstract FROM Category';
            $this->_selectAllStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as Category instances array and return it
        $this->_selectAllStatement->execute();
        $this->_selectAllStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectAllStatement->fetch())
            $result[] = new Category($line);
        return $result;
    }

    /**
     * Get all records from table ordered by a column Category
     * @param string $column column name
     * @return Category|Array
     */
    public function selectAllOrderBy($column) {
        //initialize the prepared statement if it is not
        $result = array();
        if(!isset($this->_selectAllOrderByStatement)) {
            $statement = 'SELECT idCategory AS id, name, abstract FROM Category ORDER BY '.$column;
            $this->_selectAllOrderByStatement = Connection::getConnection()->prepare($statement);
        }

        //Get the results as Category instances array and return it
        $this->_selectAllOrderByStatement->execute();
        $this->_selectAllOrderByStatement->setFetchMode(PDO::FETCH_ASSOC);
        while($line = $this->_selectAllOrderByStatement->fetch())
            $result[] = new Category($line);
        return $result;
    }

    /**
     * Delete from Category table by primary key
     * @param int $id primary key
     */
    public function delete($id) {
        //initialize the prepared statement if it is not
        if(!isset($this->_deleteStatement)) {
            $statement = 'DELETE FROM Category WHERE idCategory = :id';
            $this->_deleteStatement = Connection::getConnection()->prepare($statement);
        }

        //execute query
        $this->_deleteStatement->execute(array('id' => $id));
    }

    /**
     * Insert record into table Category
     * @param Category $category primary key
     */
    public function insert($category) {
        //create the statement
        $attributes = $category->getNotNullValues();
        $columns = array();
        $values = array();
        foreach($attributes as $key => $value) {
            $columns[] = $key;
            $values[] = $value;
        }
        $statement = 'INSERT INTO Category('.implode(', ', $columns).') VALUES ('.implode(', ', $values).')';
        //prepare and execute the statement
        $query = Connection::getConnection()->prepare($statement);
        $query->execute();
    }

    /**
     * Update record from table Category
     * @param Category $category primary key
     */
    public function update($category) {
        //create the statement
        $attributes = $category->check();
        $statement = 'UPDATE Category SET ';
        foreach($attributes as &$attribute)
            $statement .= $attribute.getName().' = '.$attribute.getType().', ';
        $statement = rtrim($statement, ', ');
        $statement .= ' WHERE idCategory = '.$category->getId();

        //prepare and execute the statement
        $query = Connection::getConnection()->prepare($statement);
        $query->execute();
    }
    /**
    * Update all the records of children for the selected category
    * @param Category selected + category
    */
    public function updateChildren($category) {
        //get all the existing records for this category
        $existing = Domain::domainArrayAsIdArray( selectByIdCategory($category->getId()) );
        $target = Domain::domainArrayAsIdArray( $category->getChildren);

        //get all records to add as a string : '(idCategory, idCategory), (idCategory, idCategory), ...)'
        $toAdd = array_diff($target, $existing);
        foreach($toAdd as &$item) {
            $item = implode(', ', array($category->getId(), $item));
        }
        $toAdd = '('.implode('), (', $toAdd).')';

        //prepare statements if not set
        if( !isset($this->_deleteCategoryCategoryStatement) ) {
            $cnx = Connection::getConnection();

            //delete statement
            $statement = 'DELETE * FROM null WHERE idCategory = :idCategory AND idCategory NOT IN (:target)';
            $this->_deleteCategoryChildrenStatement = $cnx->prepareStatement($statement);

            //delete statement
            $statement = 'INSERT INTO null (idCategory, idCategory) VALUES :insert';
            $this->_insertCategoryChildrenStatement = $cnx->prepareStatement($statement);
        }

        $this->_deleteCategoryChildrenStatement->execute( array('target' => implode(', ', $target)) );
        $this->_insertCategoryChildrenStatement->execute( array('target' => implode(', ', $toAdd)) );
    }
    /**
    * Update all the records of publications for the selected category
    * @param Category selected + category
    */
    public function updatePublications($category) {
        //get all the existing records for this category
        $existing = Domain::domainArrayAsIdArray( selectByIdPublication($category->getId()) );
        $target = Domain::domainArrayAsIdArray( $category->getPublications);

        //get all records to add as a string : '(idCategory, idPublication), (idCategory, idPublication), ...)'
        $toAdd = array_diff($target, $existing);
        foreach($toAdd as &$item) {
            $item = implode(', ', array($category->getId(), $item));
        }
        $toAdd = '('.implode('), (', $toAdd).')';

        //prepare statements if not set
        if( !isset($this->_deleteCategoryPublicationStatement) ) {
            $cnx = Connection::getConnection();

            //delete statement
            $statement = 'DELETE * FROM null WHERE idCategory = :idCategory AND idPublication NOT IN (:target)';
            $this->_deleteCategoryPublicationsStatement = $cnx->prepareStatement($statement);

            //delete statement
            $statement = 'INSERT INTO null (idCategory, idPublication) VALUES :insert';
            $this->_insertCategoryPublicationsStatement = $cnx->prepareStatement($statement);
        }

        $this->_deleteCategoryPublicationsStatement->execute( array('target' => implode(', ', $target)) );
        $this->_insertCategoryPublicationsStatement->execute( array('target' => implode(', ', $toAdd)) );
    }
}
