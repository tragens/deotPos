<?php namespace App\Models;
  
use CodeIgniter\Model;
  
class SitesettingsModel extends Model{
    protected $table = 'db_sitesettings';
    protected $allowedFields = ['id', 'version', 'site_name', 'logo', 'language_id', 'currency_id', 'currency_placement', 'timezone', 'date_format', 'time_format', 'sales_discount', 'site_url', 'site_title', 'meta_title', 'meta_desc', 'meta_keywords', 'currencysymbol_id', 'regno_key', 'copyright', 'facebook_url', 'twitter_url', 'youtube_url', 'analytic_code', 'fav_icon', 'footer_logo', 'company_id', 'purchase_code', 'change_return', 'sales_invoice_format_id', 'sales_invoice_footer_text', 'round_off', 'machine_id', 'domain', 'show_upi_code', 'unique_code', 'disable_tax', 'number_to_words'];



}

