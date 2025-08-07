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


    public function hold_invoice_list()
    {
        // Access incoming POST data directly
        $data = $_POST;  // Example: you could use $this->request->getPost() in a real-world scenario

        $i = 0;
        $str = '';

        // Fetch data from the database using CI4's DB class
        $builder = $this->db->table('db_hold');
        $query = $builder->orderBy('id', 'desc')->get();

        // Check if any records are found
        if ($query->getNumRows() > 0) {
            foreach ($query->getResult() as $res2) {
                $str .= "<tr>";
                $str .= "<td>" . $res2->id . "</td>";
                $str .= "<td>" . show_date($res2->sales_date) . "</td>";
                $str .= "<td>" . $res2->reference_id . "</td>";
                $str .= "<td>";
                $str .= '<a class="fa fa-fw fa-trash-o text-red" style="cursor: pointer;font-size: 20px;" onclick="hold_invoice_delete(' . $res2->id . ')" title="Delete Invoice?"></a>';
                $str .= '<a class="fa fa-fw fa-edit text-success" style="cursor: pointer;font-size: 20px;" onclick="hold_invoice_edit(' . $res2->id . ')" title="Edit Invoice?"></a>';
                $str .= "</td>";
                $str .= "</tr>";
                $i++;
            }
        } else {
            $str .= "<tr>";
            $str .= '<td colspan="4" class="text-danger text-center">No Records Found</td>';
            $str .= '</tr>';
        }

        return $str;
    }


}

