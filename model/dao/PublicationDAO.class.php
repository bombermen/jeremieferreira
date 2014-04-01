<?php

/**
 * Description of PublicationDAO
 *
 * @author Jeremie FERREIRA
 */
interface PublicationDAO {
    /**
     * Get domain object Publication by primary key
     * @param int $id primary key
     * @return Publication
     */
    public function load($id);
    /**
     * Get all records from table Publication
     * @return Publication|Array
     */
    public function selectAll();
    /**
     * Get all records from table ordered by a column Publication
     * @param string $column column name
     * @return Publication|Array
     */
    public function selectAllOrderBy($column);
    /**
     * Delete from Publication table by primary key
     * @param int $id primary key
     */
    public function delete($id);
    /**
     * Insert record into table Publication
     * @param Publication $publication primary key
     */
    public function insert($publication);
    /**
     * Update record from table Publication
     * @param Publication $publication primary key
     */
    public function update($publication);
}
