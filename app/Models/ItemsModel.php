<?php namespace App\Models;
  
use CodeIgniter\Model;
  
class ItemsModel extends Model{
    protected $table = 'db_items';
    protected $allowedFields = ['id', 'item_code', 'custom_barcode', 'item_name', 'description', 'category_id', 'sku', 'hsn', 'unit_id', 'alert_qty', 'brand_id', 'lot_number', 'expire_date', 'price', 'tax_id', 'purchase_price', 'tax_type', 'profit_margin', 'sales_price', 'final_price', 'stock', 'item_image', 'system_ip', 'system_name', 'created_date', 'created_time', 'created_by', 'company_id', 'status', 'discount_type', 'discount'];



}

