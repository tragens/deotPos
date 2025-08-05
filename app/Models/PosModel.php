<?php namespace App\Models;
  
use CodeIgniter\Model;
  
class PosModel extends Model{
    // protected $table = '';
    // protected $allowedFields = [];
    public function update_items_quantity($item_id)
    {
        $db = \Config\Database::connect();

        // Fetch all required stock values using Query Builder
        $stock_qty = $db->table('db_stockentry')
            ->selectSum('qty', 'stock_qty')
            ->where('item_id', $item_id)
            ->get()
            ->getRow()
            ->stock_qty ?? 0;

        $pu_tot_qty = $db->table('db_purchaseitems')
            ->selectSum('purchase_qty', 'pu_tot_qty')
            ->where([
                'item_id' => $item_id,
                'purchase_status' => 'Received'
            ])
            ->get()
            ->getRow()
            ->pu_tot_qty ?? 0;

        $sl_tot_qty = $db->table('db_salesitems')
            ->selectSum('sales_qty', 'sl_tot_qty')
            ->where([
                'item_id' => $item_id,
                'sales_status' => 'Final'
            ])
            ->get()
            ->getRow()
            ->sl_tot_qty ?? 0;

        $pu_return_tot_qty = $db->table('db_purchaseitemsreturn')
            ->selectSum('return_qty', 'pu_return_tot_qty')
            ->where('item_id', $item_id)
            ->get()
            ->getRow()
            ->pu_return_tot_qty ?? 0;

        $sl_return_tot_qty = $db->table('db_salesitemsreturn')
            ->selectSum('return_qty', 'sl_return_tot_qty')
            ->where('item_id', $item_id)
            ->get()
            ->getRow()
            ->sl_return_tot_qty ?? 0;

        // Final stock calculation
        $stock = (($stock_qty + $pu_tot_qty - $sl_tot_qty) + $sl_return_tot_qty) - $pu_return_tot_qty;

        // Update the db_items table
        $update = $db->table('db_items')
            ->where('id', $item_id)
            ->update(['stock' => $stock]);

        return $update;
    }

}

