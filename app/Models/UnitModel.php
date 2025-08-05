<?php namespace App\Models;
  
use CodeIgniter\Model;
  
class UnitModel extends Model{
    
    protected $table = 'db_units';
    protected $allowedFields = ['id', 'unit_name', 'description', 'company_id', 'status'];

}

