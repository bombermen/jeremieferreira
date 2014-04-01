<?php

/**
 * Description of TagDAO
 *
 * @author Jeremie FERREIRA
 */
interface TagDAO {
    /**
     * Get domain object Tag by primary key
     * @param int $id primary key
     * @return Tag
     */
    public function load($id);
    /**
     * Get all records from table Tag
     * @return Tag|Array
     */
    public function selectAll();
    /**
     * Get all records from table ordered by a column Tag
     * @param string $column column name
     * @return Tag|Array
     */
    public function selectAllOrderBy($column);
    /**
     * Delete from Tag table by primary key
     * @param int $id primary key
     */
    public function delete($id);
    /**
     * Insert record into table Tag
     * @param Tag $tag primary key
     */
    public function insert($tag);
    /**
     * Update record from table Tag
     * @param Tag $tag primary key
     */
    public function update($tag);
}
