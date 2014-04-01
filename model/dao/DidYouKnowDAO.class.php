<?php

/**
 * Description of DidYouKnowDAO
 *
 * @author Jeremie FERREIRA
 */
interface DidYouKnowDAO {
    /**
     * Get domain object DidYouKnow by primary key
     * @param int $id primary key
     * @return DidYouKnow
     */
    public function load($id);
    /**
     * Get all records from table DidYouKnow
     * @return DidYouKnow|Array
     */
    public function selectAll();
    /**
     * Get all records from table ordered by a column DidYouKnow
     * @param string $column column name
     * @return DidYouKnow|Array
     */
    public function selectAllOrderBy($column);
    /**
     * Delete from DidYouKnow table by primary key
     * @param int $id primary key
     */
    public function delete($id);
    /**
     * Insert record into table DidYouKnow
     * @param DidYouKnow $didYouKnow primary key
     */
    public function insert($didYouKnow);
    /**
     * Update record from table DidYouKnow
     * @param DidYouKnow $didYouKnow primary key
     */
    public function update($didYouKnow);
}
