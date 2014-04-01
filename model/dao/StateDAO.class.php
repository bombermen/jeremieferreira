<?php

/**
 * Description of StateDAO
 *
 * @author Jeremie FERREIRA
 */
interface StateDAO {
    /**
     * Get domain object State by primary key
     * @param int $id primary key
     * @return State
     */
    public function load($id);
    /**
     * Get all records from table State
     * @return State|Array
     */
    public function selectAll();
    /**
     * Get all records from table ordered by a column State
     * @param string $column column name
     * @return State|Array
     */
    public function selectAllOrderBy($column);
    /**
     * Delete from State table by primary key
     * @param int $id primary key
     */
    public function delete($id);
    /**
     * Insert record into table State
     * @param State $state primary key
     */
    public function insert($state);
    /**
     * Update record from table State
     * @param State $state primary key
     */
    public function update($state);
}
