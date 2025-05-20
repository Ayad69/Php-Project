<?php
interface DAO {
    
    public function getAll();
    
  
    public function getById($id);
    
  
    public function add($item);
    

    public function update($item);
    
  
    public function delete($id);
}