<?php

/**
 * Description of TechnologyDAO
 *
 * @author Jeremie FERREIRA
 */
interface TechnologyDAO {
    /**
     * Get domain object Technology by primary key
     * @param int $id primary key
     * @return Technology
     */
    public function load($id);
    /**
     * Get all records from table Technology
     * @return Technology|Array
     */
    public function selectAll();
    /**
     * Get all records from table ordered by a column Technology
     * @param string $column column name
     * @return Technology|Array
     */
    public function selectAllOrderBy($column);
    /**
     * Delete from Technology table by primary key
     * @param int $id primary key
     */
    public function delete($id);
    /**
     * Insert record into table Technology
     * @param Technology $technology primary key
     */
    public function insert($technology);
    /**
     * Update record from table Technology
     * @param Technology $technology primary key
     */
    public function update($technology);
}
