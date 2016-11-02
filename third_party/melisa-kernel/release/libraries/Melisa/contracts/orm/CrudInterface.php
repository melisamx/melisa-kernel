<?php

namespace Melisa\contracts\orm;

/**
 * 
 *
 * @author Luis Josafat Heredia Contreras
 */
interface CrudInterface
{
    
    public function create(array $input = [], array $config = []);
    public function readPaging(array $input = [], array $config = []);
    public function readById($id, array $config = []);
    public function update(array $input = [], array $config = []);
    public function delete($id, array $config = []);
    
}
