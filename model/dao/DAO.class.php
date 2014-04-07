<?php

/**
 * Description of DAO
 * 
 * @author Jeremie
 */
interface DAO {
    
    /**
     * @param int $id
     * @return Domain
     */
    public function load($id);
    
    /**
     * @return Domain|Array
     */
    public function selectAll();
    
    /**
     * @param string $column
     * @return Domain|Array
     */
    public function selectAllOrderBy($column);
    
    /**
     * @param Domain $domain
     */
    public function delete($domain);
    
    /**
     * @param Domain $domain
     */
    public function insert($domain);

    /**
     * @param Domain $domain
     */
    public function update($domain);
}
