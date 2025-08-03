<?php namespace App\Models;
  
use CodeIgniter\Model;
  
class PurchaseModel extends Model{
    protected $table = 'db_purchase';
    protected $allowedFields = ['id', 'purchase_code', 'reference_no', 'purchase_date', 'purchase_status', 'supplier_id', 'warehouse_id', 'other_charges_input', 'other_charges_tax_id', 'other_charges_amt', 'discount_to_all_input', 'discount_to_all_type', 'tot_discount_to_all_amt', 'subtotal', 'round_off', 'grand_total', 'purchase_note', 'payment_status', 'paid_amount', 'created_date', 'created_time', 'created_by', 'system_ip', 'system_name', 'company_id', 'status', 'return_bit'];



}

