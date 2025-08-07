<?php namespace App\Models;
  
use CodeIgniter\Model;
  
class CompanyModel extends Model{
    protected $table = 'db_company';
    protected $allowedFields = ['id', 'company_code', 'company_name', 'company_website', 'mobile', 'phone', 'email', 'website', 'company_logo', 'logo', 'upi_id', 'upi_code', 'signature', 'show_signature', 'country', 'state', 'city', 'address', 'postcode', 'gst_no', 'vat_no', 'pan_no', 'bank_details', 'cid', 'category_init', 'item_init', 'supplier_init', 'purchase_init', 'purchase_return_init', 'customer_init', 'sales_init', 'sales_return_init', 'expense_init', 'invoice_view', 'status', 'sms_status', 'sales_terms_and_conditions'];



}

