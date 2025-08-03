<?php

/**
 * Author: Jerald Sabato
 * Date: 08/2025
 */

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class DashboardModel extends Model
{
    protected $db;
    protected $coredata;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
        $this->coredata = service('coredata');
    }

    private function getSum(string $table, string $column, array $where = []): float
    {
        $builder = $this->db->table($table)->selectSum($column);
        if (!empty($where)) {
            $builder->where($where);
        }

        return (float) ($builder->get()->getRow()->{$column} ?? 0);
    }

    public function breadboard_values(): array
    {
        $today = Time::now('Asia/Manila')->toDateString(); // adjust timezone as needed

        $tot_sup  = $this->db->table('db_suppliers')->countAll();
        $tot_pro  = $this->db->table('db_items')->countAll();
        $tot_cust = $this->db->table('db_customers')->countAll();

        $tot_pur = $this->db->table('db_purchase')
                            ->where('purchase_status', 'Received')
                            ->countAllResults();

        $tot_sal = $this->db->table('db_sales')
                            ->where('sales_status', 'Final')
                            ->countAllResults();

        $tot_sal_grand_total = $this->getSum('db_sales', 'grand_total', ['sales_status' => 'Final']);
        $tot_sales_return    = $this->getSum('db_salesreturn', 'grand_total');
        $tot_exp             = $this->getSum('db_expense', 'expense_amt');

        // Sales Due
        $sales_totals = $this->db->table('db_sales')
                                 ->select('SUM(grand_total) as total, SUM(paid_amount) as paid')
                                 ->where('sales_status', 'Final')
                                 ->get()->getRow();

        $sales_due = ($sales_totals->total ?? 0) - ($sales_totals->paid ?? 0);

        // Purchase Due
        $purchase_totals = $this->db->table('db_purchase')
                                    ->select('SUM(grand_total) as total, SUM(paid_amount) as paid')
                                    ->where('purchase_status', 'Received')
                                    ->get()->getRow();

        $purchase_due = ($purchase_totals->total ?? 0) - ($purchase_totals->paid ?? 0);

        // Payments today
        $today_payment_received = $this->getSum('db_salespayments', 'payment', ['payment_date' => $today]);
        $today_payment_paid     = $this->getSum('db_salespaymentsreturn', 'payment', ['payment_date' => $today]);

        $todays_total_purchase       = $this->getSum('db_purchase', 'grand_total', ['purchase_date' => $today]);
        $todays_total_sales          = $this->getSum('db_sales', 'grand_total', ['sales_status' => 'Final', 'sales_date' => $today]);
        $todays_total_sales_return   = $this->getSum('db_salesreturn', 'grand_total', ['return_date' => $today]);
        $todays_total_expense        = $this->getSum('db_expense', 'expense_amt', ['expense_date' => $today]);

        return [
            'tot_sup'                => $tot_sup,
            'tot_pro'                => $tot_pro,
            'tot_cust'               => $tot_cust,
            'tot_pur'                => $tot_pur,
            'tot_sal'                => $tot_sal,
            'tot_sal_grand_total'    => $tot_sal_grand_total - $tot_sales_return,
            'tot_exp'                => $tot_exp,
            'sales_due'              => $sales_due,
            'purchase_due'           => $this->coredata->currency($purchase_due),
            'today_payment_received' => $today_payment_received - $today_payment_paid,
            'todays_total_purchase'  => $todays_total_purchase,
            'todays_total_sales'     => $todays_total_sales - $todays_total_sales_return,
            'todays_total_expense'   => $todays_total_expense,
        ];
    }
}
