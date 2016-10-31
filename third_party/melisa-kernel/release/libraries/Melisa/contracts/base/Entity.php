<?php 

namespace Melisa\contracts;

/* 
 * Represent one table in database
 */
interface Entity
{
    
    public function delete($id, array $config = []);
    
    public function update(array $input, array $config = []);
    
    public function readById($id, array $config = []);
    
    public function readPaging(array $input, array $config = []);
    
    public function create(array $input, array $config = []);
    
}
