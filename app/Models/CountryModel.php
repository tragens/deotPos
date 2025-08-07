<?php namespace App\Models;
  
use CodeIgniter\Model;
  
class CountryModel extends Model{
    protected $table = 'db_country';
    protected $allowedFields = ['id', 'country_code', 'country', 'added_on', 'company_id', 'status'];



}

