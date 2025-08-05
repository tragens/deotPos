<?php namespace App\Models;
  
use CodeIgniter\Model;
  
class TaxModel extends Model{
    protected $table = 'db_tax';
    protected $allowedFields = ['id', 'tax_name', 'tax', 'group_bit', 'subtax_ids', 'status', 'undelete_bit'];



}

