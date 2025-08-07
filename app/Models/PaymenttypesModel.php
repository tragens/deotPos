<?php namespace App\Models;
  
use CodeIgniter\Model;
  
class PaymenttypesModel extends Model{
    protected $table = 'db_paymenttypes';
    protected $allowedFields = ['id', 'payment_type', 'status'];



}

