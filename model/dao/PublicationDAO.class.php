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
     * Select all Publication records refering to Person
     * @return Publication|Array
     */
    public function selectByIdPerson($idPerson);
    /**
     * Select all Publication records refering to Idea
     * @return Publication|Array
     */
    public function selectByIdIdea($idIdea);
    /**
     * Select all Publication records refering to Technology
     * @return Publication|Array
     */
    public function selectByIdTechnology($idTechnology);
    /**
     * Select all Publication records refering to Tag
     * @return Publication|Array
     */
    public function selectByIdTag($idTag);
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
    /**
     * Select all Publication records refering to Person
     * @return Publication|Array
     */
    public function updatePersons($publication);
    /**
     * Select all Publication records refering to Idea
     * @return Publication|Array
     */
    public function updateIdeas($publication);
    /**
     * Select all Publication records refering to Technology
     * @return Publication|Array
     */
    public function updateTechnologies($publication);
    /**
     * Select all Publication records refering to Tag
     * @return Publication|Array
     */
    public function updateTags($publication);
}
