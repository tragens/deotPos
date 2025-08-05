<?php namespace App\Models;
  
use CodeIgniter\Model;
  
class ItemsModel extends Model{
    protected $table = 'db_items';
    protected $allowedFields = ['id', 'item_code', 'custom_barcode', 'item_name', 'description', 'category_id', 'sku', 'hsn', 'unit_id', 'alert_qty', 'brand_id', 'lot_number', 'expire_date', 'price', 'tax_id', 'purchase_price', 'tax_type', 'profit_margin', 'sales_price', 'final_price', 'stock', 'item_image', 'system_ip', 'system_name', 'created_date', 'created_time', 'created_by', 'company_id', 'status', 'discount_type', 'discount'];


    protected $table_as = 'db_items as a';
    protected $column_order = [
        'a.id', 'a.item_image', 'a.item_code', 'a.item_name', 'b.category_name', 
        'c.unit_name', 'a.stock', 'a.alert_qty', 'a.purchase_price', 'a.final_price', 
        'd.tax_name', 'd.tax', 'a.status', 'e.brand_name', 'a.tax_type', 'a.hsn', 'a.sku'
    ]; // Columns for orderable data

    protected $column_search = [
        'a.id', 'a.item_image', 'a.item_code', 'a.item_name', 'b.category_name', 
        'c.unit_name', 'a.stock', 'a.alert_qty', 'a.purchase_price', 'a.final_price', 
        'd.tax_name', 'd.tax', 'a.status', 'e.brand_name', 'a.custom_barcode', 
        'a.tax_type', 'a.hsn', 'a.sku'
    ]; // Columns for searchable data

    protected $order = ['a.id' => 'desc']; // Default ordering

    private function _get_datatables_query()
    {
        $builder = $this->db->table($this->table_as);
        $builder->select($this->column_order);
        $builder->select("CASE WHEN e.brand_name IS NULL THEN '' ELSE e.brand_name END AS brand_name");
        $builder->join('db_brands as e', 'e.id = a.brand_id', 'left');
        $builder->join('db_category as b', 'b.id = a.category_id', 'left');
        $builder->join('db_units as c', 'c.id = a.unit_id', 'left');
        $builder->join('db_tax as d', 'd.id = a.tax_id', 'left');

        // Get filter parameters from POST
        $brand_id = service('request')->getPost('brand_id');
        $category_id = service('request')->getPost('category_id');
        
        // Apply filters if set
        if (!empty($brand_id)) {
            $builder->where("a.brand_id", $brand_id);
        }
        if (!empty($category_id)) {
            $builder->where("a.category_id", $category_id);
        }

        // Search filter
        $searchValue = service('request')->getPost('search')['value'] ?? '';
        if ($searchValue) {
            $i = 0;
            foreach ($this->column_search as $item) {
                if ($i === 0) {
                    $builder->groupStart();
                    $builder->like($item, $searchValue);
                } else {
                    $builder->orLike($item, $searchValue);
                }
                if (count($this->column_search) - 1 == $i) {
                    $builder->groupEnd();
                }
                $i++;
            }
        }

        // Order handling
        if (service('request')->getPost('order')) {
            $orderColumnIndex = service('request')->getPost('order')[0]['column'];
            $orderDirection = service('request')->getPost('order')[0]['dir'];
            $orderColumn = $this->column_order[$orderColumnIndex];
            $builder->orderBy($orderColumn, $orderDirection);
        } else if (isset($this->order)) {
            $order = $this->order;
            $builder->orderBy(key($order), $order[key($order)]);
        }
        return $builder;
    }

    public function get_datatables()
    {
        // Initialize the query builder
        $builder = $this->_get_datatables_query(); // 
        
        // Get the pagination parameters
        $length = service('request')->getPost('length');
        $start = service('request')->getPost('start');

        // Apply limit for pagination using the query builder
        if ($length != -1) {
            $builder->limit($length, $start);
        }

        // Execute the query and get the results
        $query = $builder->get();
        return $query->getResult(); // Return the result set
    }


    public function count_all()
    {
        return $this->db->table($this->table)->countAllResults();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->table($this->table_as)->get();
        return $query->getNumRows();
    }


    // public function verify_and_save()
    // {
    //     $request = \Config\Services::request();
    //     $db = \Config\Database::connect();

    //     $builder = $db->table('db_items');
    //     $file_name = '';

    //     // Begin Transaction
    //     $db->transStart();

    //     // Handle File Upload
    //     $image = $request->getFile('item_image');
    //     if ($image && $image->isValid() && !$image->hasMoved()) {
    //         $newName = time() . '.' . $image->getExtension();
    //         $uploadPath = WRITEPATH . '/uploads/items/';

    //         $image->move($uploadPath, $newName);
    //         $file_name = 'uploads/items/' . $newName;

    //         // Create Thumbnail
    //         $imageService = \Config\Services::image();
    //         $imageService->withFile($uploadPath . $newName)
    //                      ->resize(75, 50, true, 'height')
    //                      ->save($uploadPath . 'thumb_' . $newName);
    //     }

    //     // Prepare input data
    //     $data = [
    //         'item_code'        => $request->getPost('item_code'),
    //         'item_name'        => $request->getPost('item_name'),
    //         'brand_id'         => $request->getPost('brand_id'),
    //         'category_id'      => $request->getPost('category_id'),
    //         'sku'              => $request->getPost('sku'),
    //         'hsn'              => $request->getPost('hsn'),
    //         'unit_id'          => $request->getPost('unit_id'),
    //         'alert_qty'        => $request->getPost('alert_qty') ?? 0,
    //         'lot_number'       => $request->getPost('lot_number'),
    //         'expire_date'      => $request->getPost('expire_date') ? date('Y-m-d', strtotime($request->getPost('expire_date'))) : null,
    //         'price'            => $request->getPost('price'),
    //         'tax_id'           => $request->getPost('tax_id'),
    //         'purchase_price'   => $request->getPost('purchase_price'),
    //         'tax_type'         => $request->getPost('tax_type'),
    //         'profit_margin'    => $request->getPost('profit_margin') ?: null,
    //         'sales_price'      => $request->getPost('sales_price'),
    //         'custom_barcode'   => $request->getPost('custom_barcode'),
    //         'final_price'      => $request->getPost('final_price'),
    //         'description'      => $request->getPost('description'),
    //         'status'           => 1,
    //         'discount'         => $request->getPost('discount') ?? 0,
    //         'discount_type'    => $request->getPost('discount_type'),
    //         'item_image'       => $file_name,
    //         'system_ip'        => $request->getIPAddress(),
    //         'system_name'      => php_uname('n'),
    //         'created_date'     => date('Y-m-d'),
    //         'created_time'     => date('H:i:s'),
    //         'created_by'       => session()->get('username') ?? 'admin'
    //     ];

    //     // Insert into db_items
    //     $builder->insert($data);
    //     $item_id = $db->insertID();

    //     if (!$item_id) {
    //         $db->transRollback();
    //         return 'failed';
    //     }

    //     // Handle opening stock
    //     $opening_stock = $request->getPost('new_opening_stock');
    //     if (!empty($opening_stock) && $opening_stock != 0) {
    //         $adjustment_note = $request->getPost('adjustment_note') ?? '';

    //         if (!$this->stock_entry(date('Y-m-d'), $item_id, $opening_stock, $adjustment_note)) {
    //             $db->transRollback();
    //             return 'failed';
    //         }
    //     }

    //     // Update item quantity (call to another model, if needed)
    //     $posModel = new \App\Models\PosModel();
    //     if (!$posModel->update_items_quantity($item_id)) {
    //         $db->transRollback();
    //         return 'failed';
    //     }

    //     $db->transCommit();

    //     session()->setFlashdata('success', 'Success! New item added successfully.');
    //     return 'success';
    // }


}

