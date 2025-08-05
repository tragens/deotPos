<?php namespace App\Models;
  
use CodeIgniter\Model;
  
class CategoryModel extends Model{
    
    protected $table = 'db_category';
    protected $allowedFields = ['id', 'category_code', 'category_name', 'description', 'company_id', 'status'];

}

