<?php

use Config\Database;
use Config\Services;
use App\Libraries\MyCoredata;

if (!function_exists('demo_app')) {
    function demo_app(): bool {
        return false;
    }
}

if (!function_exists('app_version')) {
    function app_version(): string {
        return '2.4';
    }
}

if (!function_exists('sql_mode')) {
    function sql_mode(): string {
        $db = Database::connect();
        $result = $db->query("SELECT @@sql_mode AS sql_mode")->getRow();
        return $result->sql_mode ?? '';
    }
}

if (!function_exists('is_sql_full_group_by_enabled')) {
    function is_sql_full_group_by_enabled() {
        $sql_mode = strtoupper(sql_mode());
        $mode = 'ONLY_FULL_GROUP_BY';
        return (strpos($sql_mode, $mode) !== false) ? show_sql_mode_page() : false;
    }
}

if (!function_exists('show_sql_mode_page')) {
    function show_sql_mode_page() {
        $db = Database::connect();
        $result = $db->query("SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
        if (!$result) {
            show_error("Please make sure your database is not enabled with SQL_FULL_GROUP_BY. For more info, <a href='" . base_url('/help/#full_group_by') . "' target='_blank'>click here</a>.", 403, "SQL_FULL_GROUP_BY ENABLED!!");
        }
        return true;
    }
}

if (!function_exists('system_fromatted_date')) {
    function system_fromatted_date($date = '') {
        $session = Services::session();
        $format = $session->get('view_date');
        if ($format == 'dd/mm/yyyy') {
            return date('Y-m-d', strtotime(str_replace('/', '-', $date)));
        } elseif ($format == 'mm/dd/yyyy') {
            return date("Y-m-d", strtotime($date));
        }
        return date("Y-m-d", strtotime($date));
    }
}

if (!function_exists('show_date')) {
    function show_date($date = '') {
        $session = Services::session();
        $format = $session->get('view_date');
        if ($format == 'dd/mm/yyyy') {
            return date('d/m/Y', strtotime(str_replace('/', '-', $date)));
        } elseif ($format == 'mm/dd/yyyy') {
            return date("m/d/Y", strtotime($date));
        }
        return date("d-m-Y", strtotime($date));
    }
}

if (!function_exists('show_time')) {
    function show_time($time = '') {
        if (empty($time)) return $time;

        $session = Services::session();
        $format = $session->get('view_time');
        return ($format == '24') ? date('H:i', strtotime($time)) : date('h:i a', strtotime($time));
    }
}

if (!function_exists('return_item_image_thumb')) {
    function return_item_image_thumb(string $path = ''): string {
        return str_replace(".", "_thumb.", $path);
    }
}

if (!function_exists('change_return_status')) {
    function change_return_status() {
        $db = Database::connect();
        return $db->table('db_sitesettings')->select('change_return')->get()->getRow()->change_return ?? null;
    }
}

if (!function_exists('get_change_return_amount')) {
    function get_change_return_amount($sales_id) {
        $db = Database::connect();
        $result = $db->table('db_salespayments')
                     ->select('COALESCE(SUM(change_return), 0) AS change_return_amount')
                     ->where('sales_id', $sales_id)
                     ->get()->getRow();
        return $result->change_return_amount ?? 0;
    }
}

if (!function_exists('get_invoice_format_id')) {
    function get_invoice_format_id() {
        $db = Database::connect();
        return $db->table('db_sitesettings')->select('sales_invoice_format_id')->where('id', 1)->get()->getRow()->sales_invoice_format_id ?? null;
    }
}

if (!function_exists('is_enabled_round_off')) {
    function is_enabled_round_off(): bool {
        $db = Database::connect();
        $result = $db->table('db_sitesettings')->select('round_off')->where('id', 1)->get()->getRow();
        return ($result->round_off ?? 0) == 1;
    }
}

if (!function_exists('get_profile_picture')) {
    function get_profile_picture(): string {
        $db = Database::connect();
        $session = Services::session();
        $userId = $session->get('inv_userid');

        $result = $db->table('db_users')->select('profile_picture')->where('id', $userId)->get()->getRow();
        return (!empty($result->profile_picture)) ? base_url($result->profile_picture) : base_url("theme/dist/img/avatar5.png");
    }
}

if (!function_exists('record_customer_payment')) {
    function record_customer_payment($customer_id = null) {
        $db = Database::connect();
        $builder = $db->table('db_customer_payments');

        if (empty($customer_id)) {
            $builder->delete();
        } else {
            $builder->where('customer_id', $customer_id)->delete();
        }

        $customer_condition = $customer_id ? "AND b.customer_id = $customer_id" : '';

        $query = "
            INSERT INTO db_customer_payments 
            (salespayment_id, customer_id, payment_date, payment_type, payment, payment_note, 
             system_ip, system_name, created_date, created_time, created_by, status)
            SELECT a.id, b.customer_id, a.payment_date, a.payment_type, 
                   COALESCE(SUM(a.payment)), a.payment_note,
                   a.system_ip, a.system_name, a.created_date, a.created_time, a.created_by, 1
            FROM db_salespayments a, db_sales b
            WHERE b.id = a.sales_id $customer_condition
            GROUP BY b.customer_id, a.payment_type, a.payment_date, a.created_time, a.created_date
        ";

        return $db->query($query) !== false;
    }
}

if (!function_exists('record_supplier_payment')) {
    function record_supplier_payment($supplier_id = null) {
        $db = Database::connect();
        $builder = $db->table('db_supplier_payments');

        if (empty($supplier_id)) {
            $builder->delete();
        } else {
            $builder->where('supplier_id', $supplier_id)->delete();
        }

        $supplier_condition = $supplier_id ? "AND b.supplier_id = $supplier_id" : '';

        $query = "
            INSERT INTO db_supplier_payments 
            (purchasepayment_id, supplier_id, payment_date, payment_type, payment, payment_note, 
             system_ip, system_name, created_date, created_time, created_by, status)
            SELECT a.id, b.supplier_id, a.payment_date, a.payment_type, 
                   COALESCE(SUM(a.payment)), a.payment_note,
                   a.system_ip, a.system_name, a.created_date, a.created_time, a.created_by, 1
            FROM db_purchasepayments a, db_purchase b
            WHERE b.id = a.purchase_id $supplier_condition
            GROUP BY b.supplier_id, a.payment_type, a.payment_date, a.created_time, a.created_date
        ";

        return $db->query($query) !== false;
    }
}

if (!function_exists('calculate_inclusive')) {
    function calculate_inclusive($amount, $tax): string {
        $tot = ($amount / (($tax / 100) + 1) / 10);
        return number_format($tot, 2, ".", "");
    }
}

if (!function_exists('calculate_exclusive')) {
    function calculate_exclusive($amount, $tax): string {
        $tot = (($amount * $tax) / 100);
        return number_format($tot, 2, ".", "");
    }
}

if (!function_exists('app_number_format')) {
    function app_number_format($value = ''): ?string {
        return empty($value) ? $value : number_format($value, 2);
    }
}

if (!function_exists('show_upi_code')) {
    function show_upi_code() {
        $db = Database::connect();
        return $db->table('db_sitesettings')->select('show_upi_code')->get()->getRow()->show_upi_code ?? null;
    }
}

if (!function_exists('get_customer_details')) {
    function get_customer_details($customer_id) {
        $db = Database::connect();
        return $db->table('db_customers')->where('id', $customer_id)->get()->getRow();
    }
}

if (!function_exists('get_supplier_details')) {
    function get_supplier_details($supplier_id) {
        $db = Database::connect();
        return $db->table('db_suppliers')->where('id', $supplier_id)->get()->getRow();
    }
}

if (!function_exists('get_site_details')) {
    function get_site_details() {
        $db = Database::connect();
        return $db->table('db_sitesettings')->where('id', 1)->get()->getRow();
    }
}

if (!function_exists('is_tax_disabled')) {
    function is_tax_disabled(): bool {
        return (get_site_details()->disable_tax ?? 0) == 1;
    }
}

if (!function_exists('tax_disable_class')) {
    function tax_disable_class(): string {
        return is_tax_disabled() ? 'hide' : 'block';
    }
}

if (!function_exists('date_difference')) {
    function date_difference($start_date, $end_date): float {
        $start = strtotime(date("Y-m-d", strtotime($start_date)));
        $end = strtotime(date("Y-m-d", strtotime($end_date)));
        return ($end - $start) / (60 * 60 * 24);
    }
}

if (!function_exists('get_item_details')) {
    function get_item_details($item_id) {
        $db = Database::connect();
        return $db->table('db_items')->where('id', $item_id)->get()->getRow();
    }
}

if (!function_exists('get_country')) {
    function get_country($country_id = ''): ?string {
        if (trim($country_id) === '') return null;

        $db = Database::connect();
        $row = $db->table('db_country')->where('id', $country_id)->get()->getRow();
        return $row ? $row->country : null;
    }
}

if (!function_exists('get_state')) {
    function get_state($state_id = ''): ?string {
        if (trim($state_id) === '') return null;

        $db = Database::connect();
        $row = $db->table('db_states')->where('id', $state_id)->get()->getRow();
        return $row ? $row->country : null;
    }
}

if (!function_exists('get_sales_details')) {
    function get_sales_details($sales_id) {
        $db = Database::connect();
        return $db->table('db_sales')->where('id', $sales_id)->get()->getRow();
    }
}

if (!function_exists('permissions')) {
    function permissions($permissions = ''): bool {
        $session = Services::session();
        $db = Database::connect();

        $userId = $session->get('inv_userid');
        $roleId = $session->get('role_id');

        // If user is Admin
        if ($userId == 1) {
            return true;
        }

        $count = $db->table('db_permissions')
                    ->where('permissions', $permissions)
                    ->where('role_id', $roleId)
                    ->countAllResults();

        return $count > 0;
    }

    if (!function_exists('currency')) {
        function currency(): bool
        {
            // Create an instance of your CustomHelper library
            $perm = new MyCoredata();

            // Call the permissions method
            return $perm->currency();
        }
    }


}
