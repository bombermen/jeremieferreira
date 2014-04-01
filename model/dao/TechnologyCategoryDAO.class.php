<?php

/**
 * Description of TechnologyCategoryDAO
 *
 * @author Jeremie FERREIRA
 */
interface TechnologyCategoryDAO {
    /**
     * Get domain object TechnologyCategory by primary key
     * @param int $id primary key
     * @return TechnologyCategory
     */
    public function load($id);
    /**
     * Get all records from table TechnologyCategory
     * @return TechnologyCategory|Array
     */
    public function selectAll();
    /**
     * Get all records from table ordered by a column TechnologyCategory
     * @param string $column column name
     * @return TechnologyCategory|Array
     */
    public function selectAllOrderBy($column);
    /**
     * Delete from TechnologyCategory table by primary key
     * @param int $id primary key
     */
    public function delete($id);
    /**
     * Insert record into table TechnologyCategory
     * @param TechnologyCategory $technologyCategory primary key
     */
    public function insert($technologyCategory);
    /**
     * Update record from table TechnologyCategory
     * @param TechnologyCategory $technologyCategory primary key
     */
    public function update($technologyCategory);
}
