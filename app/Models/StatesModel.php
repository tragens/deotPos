<?php namespace App\Models;
  
use CodeIgniter\Model;
  
class StatesModel extends Model{
    protected $table = 'db_states';
    protected $allowedFields = ['id', 'state_code', 'state', 'country_code', 'country_id', 'country', 'added_on', 'company_id', 'status'];



}

