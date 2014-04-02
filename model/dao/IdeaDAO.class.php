<?php

/**
 * Description of IdeaDAO
 *
 * @author Jeremie FERREIRA
 */
interface IdeaDAO {
    /**
     * Get domain object Idea by primary key
     * @param int $id primary key
     * @return Idea
     */
    public function load($id);
    /**
     * Select all Idea records refering to Publication
     * @return Idea|Array
     */
    public function selectByIdPublication($idPublication);
    /**
     * Get all records from table Idea
     * @return Idea|Array
     */
    public function selectAll();
    /**
     * Get all records from table ordered by a column Idea
     * @param string $column column name
     * @return Idea|Array
     */
    public function selectAllOrderBy($column);
    /**
     * Delete from Idea table by primary key
     * @param int $id primary key
     */
    public function delete($id);
    /**
     * Insert record into table Idea
     * @param Idea $idea primary key
     */
    public function insert($idea);
    /**
     * Update record from table Idea
     * @param Idea $idea primary key
     */
    public function update($idea);
    /**
     * Select all Idea records refering to Publication
     * @return Idea|Array
     */
    public function updatePublications($idea);
}
