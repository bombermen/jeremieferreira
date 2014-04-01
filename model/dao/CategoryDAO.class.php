<?php

/**
 * Description of CategoryDAO
 *
 * @author Jeremie FERREIRA
 */
interface CategoryDAO {
    /**
     * Get domain object Category by primary key
     * @param int $id primary key
     * @return Category
     */
    public function load($id);
    /**
     * Get all records from table Category
     * @return Category|Array
     */
    public function selectAll();
    /**
     * Get all records from table ordered by a column Category
     * @param string $column column name
     * @return Category|Array
     */
    public function selectAllOrderBy($column);
    /**
     * Delete from Category table by primary key
     * @param int $id primary key
     */
    public function delete($id);
    /**
     * Insert record into table Category
     * @param Category $category primary key
     */
    public function insert($category);
    /**
     * Update record from table Category
     * @param Category $category primary key
     */
    public function update($category);
}
