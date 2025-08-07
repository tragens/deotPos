<?php namespace App\Models;
  
use CodeIgniter\Model;
  
class HoldModel extends Model{
    protected $table = 'db_hold';
    protected $allowedFields = ['id', 'reference_id', 'reference_no', 'sales_date', 'sales_status', 'customer_id', 'other_charges_input', 'other_charges_tax_id', 'other_charges_amt', 'discount_to_all_input', 'discount_to_all_type', 'tot_discount_to_all_amt', 'subtotal', 'round_off', 'grand_total', 'sales_note', 'pos'];



}

