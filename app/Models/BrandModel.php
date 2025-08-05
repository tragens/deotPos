<?php namespace App\Models;
  
use CodeIgniter\Model;
  
class BrandModel extends Model{
    protected $table = 'db_brands';
    protected $allowedFields = ['id', 'brand_code', 'brand_name', 'description', 'company_id', 'status'];



}

