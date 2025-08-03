<?php namespace App\Models;
  
use CodeIgniter\Model;
  
class SalesModel extends Model{
    protected $table = 'db_sales';
    protected $allowedFields = ['id', 'sales_code', 'reference_no', 'sales_date', 'sales_status', 'customer_id', 'warehouse_id', 'other_charges_input', 'other_charges_tax_id', 'other_charges_amt', 'discount_to_all_input', 'discount_to_all_type', 'tot_discount_to_all_amt', 'subtotal', 'round_off', 'grand_total', 'sales_note', 'payment_status', 'paid_amount', 'created_date', 'created_time', 'created_by', 'system_ip', 'system_name', 'company_id', 'pos', 'status', 'return_bit'];



}

