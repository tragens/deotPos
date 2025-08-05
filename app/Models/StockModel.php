<?php namespace App\Models;
  
use CodeIgniter\Model;
  
class StockModel extends Model{
    protected $table = 'db_stockentry';
    protected $allowedFields = ['id', 'entry_date', 'item_id', 'qty', 'note', 'status'];



}

