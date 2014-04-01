<?php

/**
 * Description of PersonDAO
 *
 * @author Jeremie FERREIRA
 */
interface PersonDAO {
    /**
     * Get domain object Person by primary key
     * @param int $id primary key
     * @return Person
     */
    public function load($id);
    /**
     * Get all records from table Person
     * @return Person|Array
     */
    public function selectAll();
    /**
     * Get all records from table ordered by a column Person
     * @param string $column column name
     * @return Person|Array
     */
    public function selectAllOrderBy($column);
    /**
     * Delete from Person table by primary key
     * @param int $id primary key
     */
    public function delete($id);
    /**
     * Insert record into table Person
     * @param Person $person primary key
     */
    public function insert($person);
    /**
     * Update record from table Person
     * @param Person $person primary key
     */
    public function update($person);
}
