<?php
namespace App\Controllers;

class Items extends BaseController
{

    // protected $GrantAccess;
    protected $userModel;
    protected $db;
    protected $coredata;
    protected $dashboardModel;
    protected $itemsModel;
    protected $categoryModel;
    protected $brandModel;
    protected $unitModel;
    protected $taxModel;
    protected $posModel;
    protected $stockModel;

    function __construct()
    {
        $this->db = \Config\Database::connect();
        // $this->GrantAccess = service('grantAccess');
        $this->userModel = service('userModel');
        $this->coredata = service('coredata');
        $this->dashboardModel = service('dashboardModel');
        $this->itemsModel = service('itemsModel');
        $this->categoryModel = service('categoryModel');
        $this->brandModel = service('brandModel');
        $this->unitModel = service('unitModel');
        $this->taxModel = service('taxModel');
        $this->posModel = service('posModel');
        $this->stockModel = service('stockModel');
    }

	public function index()
	{
		$this->coredata->permission_check('items_view');
		$data1 = $this->coredata->load_info();
		$data2 = $this->request->getPost();
		$data=array_merge($data1,$data2);
		$data['session'] = \Config\Services::session();
		$data['page_title'] = lang('items_list');


        $data['brands'] = $this->brandModel->where('status', 1)->findAll();
        $data['category'] = $this->categoryModel->where('status', 1)->findAll();
        


		return view('items-list',$data);
	}


    public function ajax_list()
    {
        $list = $this->itemsModel->get_datatables();

        $data = array();
        $no = 1; //$_POST['start'];
        $tax_disabled = (is_tax_disabled()) ? true : false;
        foreach ($list as $items) {
            
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" name="checkbox[]" value='.$items->id.' class="checkbox column_checkbox" >';
                        

            $row[] = (!empty($items->item_image) && file_exists($items->item_image)) ? "
                        <a title='Click for Bigger!' href='".base_url($items->item_image)."' data-toggle='lightbox'>
                        <image style='border:1px #72afd2 solid;' src='".base_url(return_item_image_thumb($items->item_image))."' width='75%' height='50%'> </a>" : "
                        <image style='border:1px #72afd2 solid;' src='".base_url()."theme/images/no_image.png' title='No Image!' width='75%' height='50%' >";
            $row[] = $items->item_code;
            $row[] = "<label class='text-blue'>".$items->item_name."</label><br><b>HSN</b>:".$items->hsn."<br><b>SKU</b>:".$items->sku;
            $row[] = $items->brand_name;
            // $this->get_brand_name($items->brand_id);
            $row[] = $items->category_name;
            $row[] = $items->unit_name;
            $row[] = $items->stock;
            $row[] = $items->alert_qty;
            $row[] = app_number_format($items->purchase_price);
            $row[] = app_number_format($items->final_price);
            $row[] = ($tax_disabled)? '<p class="text-yellow text-bold">Disabled</p>' :$items->tax_name?? ''."<br>(".$items->tax_type.")";

                    if($items->status==1){ 
                        $str= "<span onclick='update_status(".$items->id.",0)' id='span_".$items->id."'  class='label label-success' style='cursor:pointer'>Active </span>";}
                    else{ 
                        $str = "<span onclick='update_status(".$items->id.",1)' id='span_".$items->id."'  class='label label-danger' style='cursor:pointer'> Inactive </span>";
                    }
            $row[] = $str;      

                    $str2 = '<div class="btn-group" title="View Account">
                                        <a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
                                            Action <span class="caret"></span>
                                        </a>
                                        <ul role="menu" class="dropdown-menu dropdown-light pull-right">';

                                            if(has_permission('items_edit'))
                                            $str2.='<li>
                                                <a title="Edit Record ?" href="'.base_url('items/update/'.$items->id).'">
                                                    <i class="fa fa-fw fa-edit text-blue"></i>Edit
                                                </a>
                                            </li>';

                                            if(has_permission('items_delete'))
                                            $str2.='<li>
                                                <a style="cursor:pointer" title="Delete Record ?" onclick="delete_items('.$items->id.')">
                                                    <i class="fa fa-fw fa-trash text-red"></i>Delete
                                                </a>
                                            </li>
                                            
                                        </ul>
                                    </div>';            
            $row[] = $str2;

            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->itemsModel->count_all(),
                        "recordsFiltered" => $this->itemsModel->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }



    public function add()
    {
        has_permission('items_add');


        $this->coredata->permission_check('items_view');
        $data1 = $this->coredata->load_info();
        $data2 = $this->request->getPost();

        // Initializing values if item_name is not set
        $item_name = $sku = $hsn = $opening_stock = $item_code = $brand_id = $category_id = $gst_percentage = $tax_type =
        $sales_price = $purchase_price = $profit_margin = $unit_id = $price = $lot_number = "";
        $stock = 0;
        $alert_qty = 0;
        $expire_date = '';
        $description = '';
        $final_price = '';
        $tax_id = '';
        $discount = '';
        $discount_type = 'Percentage';
        
        // Create item unique number logic
        $item_init = $this->getItemInit();
        $maxid = $this->getMaxItemId();
        $item_code = $item_init . str_pad($maxid, 4, '0', STR_PAD_LEFT);

        // Pass variables to the view
        $data3 = [
             'custom_barcode' => '',
            'item_name' => $item_name,
            'sku' => $sku,
            'hsn' => $hsn,
            'opening_stock' => $opening_stock,
            'item_code' => $item_code,
            'brand_id' => $brand_id,
            'category_id' => $category_id,
            'gst_percentage' => $gst_percentage,
            'tax_type' => $tax_type,
            'sales_price' => $sales_price,
            'purchase_price' => $purchase_price,
            'profit_margin' => $profit_margin,
            'unit_id' => $unit_id,
            'price' => $price,
            'lot_number' => $lot_number,
            'stock' => $stock,
            'alert_qty' => $alert_qty,
            'expire_date' => $expire_date,
            'description' => $description,
            'final_price' => $final_price,
            'tax_id' => $tax_id,
            'discount' => $discount,
            'discount_type' => $discount_type,
            'item_code' => $item_code,

            'new_opening_stock' => '',
            'adjustment_note' => '',
        ];

        $data=array_merge($data1,$data2, $data3);
        $data['session'] = \Config\Services::session();
        $data['brands'] = $this->brandModel->where('status', 1)->findAll();
        $data['category'] = $this->categoryModel->where('status', 1)->findAll();
        $data['units'] = $this->unitModel->where('status', 1)->findAll();
        $data['taxs'] = $this->taxModel->where('status', 1)->orderBy('undelete_bit', 'ASC')->findAll();

        $data['page_title'] = lang('items');

        return view('items',$data);
    }

    private function getItemInit()
    {
        // Load the company settings from the database
        $builder = $this->db->table('db_company');
        $result = $builder->select('item_init')->get()->getRow();
        return $result ? $result->item_init : '';
    }

    private function getMaxItemId()
    {
        // Get the max item id and return it
        $builder = $this->db->table('db_items');
        $result = $builder->select('COALESCE(MAX(id), 0) + 1 AS maxid')->get()->getRow();
        return $result ? $result->maxid : 1;
    }


public function newitems()
{
    helper(['form']);

    $validationRules = [
        'item_name'       => ['label' => 'Item Name', 'rules' => 'required|trim'],
        'category_id'     => ['label' => 'Category Name', 'rules' => 'required|trim'],
        'unit_id'         => ['label' => 'Unit', 'rules' => 'required|trim'],
        'price'           => ['label' => 'Item Price', 'rules' => 'required|trim|numeric'],
        'tax_id'          => ['label' => 'Tax', 'rules' => 'required|trim'],
        'purchase_price'  => ['label' => 'Purchase Price', 'rules' => 'required|trim|numeric'],
        'sales_price'     => ['label' => 'Sales Price', 'rules' => 'required|trim|numeric'],
    ];

    if (!$this->validate($validationRules)) {
        return "Please Fill Compulsory(* marked) Fields.";
    }

    // Only get necessary and clean data
    $data = $this->request->getVar();

    $result = $this->verify_and_save($data);
    return $result;
}


public function verify_and_save($data)
{
    $request = \Config\Services::request();
    $imageService = \Config\Services::image();
    $file_name = '';

    // Begin Transaction
    $this->db->transStart();

    // Handle File Upload
    $image = $request->getFile('item_image');
    if ($image && $image->isValid() && !$image->hasMoved()) {
        $newName = time() . '.' . $image->getExtension();
        $uploadPath = FCPATH . 'uploads/items/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $image->move($uploadPath, $newName);
        $file_name = 'uploads/items/' . $newName;

        // Create thumbnail
        $imageService->withFile($uploadPath . $newName)
                     ->resize(75, 50, true, 'height')
                     ->save($uploadPath . 'thumb_' . $newName);
    }

    // Prepare insert data
    $insertData = [
        'item_code'        => $data['item_code'] ?? '',
        'item_name'        => $data['item_name'],
        'brand_id'         => $data['brand_id'] ?? null,
        'category_id'      => $data['category_id'],
        'sku'              => $data['sku'] ?? null,
        'hsn'              => $data['hsn'] ?? null,
        'unit_id'          => $data['unit_id'],
        'alert_qty'        => $data['alert_qty'] ?? 0,
        'lot_number'       => $data['lot_number'] ?? null,
        'expire_date'      => !empty($data['expire_date']) ? date('Y-m-d', strtotime($data['expire_date'])) : null,
        'price'            => $data['price'],
        'tax_id'           => $data['tax_id'],
        'purchase_price'   => $data['purchase_price'],
        'tax_type'         => $data['tax_type'] ?? '',
        'profit_margin'    => $data['profit_margin'] ?? null,
        'sales_price'      => $data['sales_price'],
        'custom_barcode'   => $data['custom_barcode'] ?? null,
        'final_price'      => $data['final_price'] ?? null,
        'description'      => $data['description'] ?? '',
        'status'           => 1,
        'discount'         => $data['discount'] ?? 0,
        'discount_type'    => $data['discount_type'] ?? null,
        'item_image'       => $file_name,
        'system_ip'        => $request->getIPAddress(),
        'system_name'      => php_uname('n'),
        'created_date'     => date('Y-m-d'),
        'created_time'     => date('H:i:s'),
        'created_by'       => session()->get('username') ?? 'admin',
    ];

    $this->itemsModel->insert($insertData);
    $item_id = $this->itemsModel->insertID();

    if (!$item_id) {
        $this->db->transRollback();
        return 'failed';
    }

    // Handle opening stock
    $opening_stock = $request->getVar('new_opening_stock');
    if (!empty($opening_stock) && $opening_stock != 0) {
        $adjustment_note = $request->getVar('adjustment_note') ?? '';

        if (!$this->stock_entry(date('Y-m-d'), $item_id, $opening_stock, $adjustment_note)) {
            $this->db->transRollback();
            return 'failed';
        }
    }

    if (!$this->posModel->update_items_quantity($item_id)) {
        $this->db->transRollback();
        return 'failed';
    }

    $this->db->transCommit();

    session()->setFlashdata('success', 'Success! New item added successfully.');
    return 'success';
}


public function stock_entry($entry_date, $item_id, $qty = 0, $note = '')
    {
        $data = [
            'entry_date' => $entry_date,
            'item_id'    => (int)$item_id,
            'qty'        => (float)$qty,
            'status'     => 1,
            'note'       => $note
        ];

        return $this->stockModel->insert($data) ? true : false;
    }

    public function update($id){
        has_permission('items_edit');
        $this->coredata->permission_check('items_view');
        $data1 = $this->coredata->load_info();
        $data2 = $this->request->getPost();
        $result=$this->get_details($id,$data);
        $data=array_merge($data,$result);
        $data['page_title']=$this->lang->line('items');
        $this->load->view('items', $data);
    }

public function get_details($id, array $data = [])
{
    // Fetch item by ID using Query Builder
    $item = $this->itemsModel->where('id', $id)->first();

    if (!$item) {
        show_404();
        exit;
    }

    // Populate the $data array with selected fields
    $data['q_id']            = $item['id'];
    $data['item_code']       = $item['item_code'];
    $data['item_name']       = $item['item_name'];
    $data['description']     = $item['description'];
    $data['brand_id']        = $item['brand_id'];
    $data['category_id']     = $item['category_id'];
    $data['sku']             = $item['sku'];
    $data['hsn']             = $item['hsn'];
    $data['unit_id']         = $item['unit_id'];
    $data['alert_qty']       = $item['alert_qty'];
    $data['price']           = $item['price'];
    $data['tax_id']          = $item['tax_id'];
    $data['purchase_price']  = $item['purchase_price'];
    $data['tax_type']        = $item['tax_type'];
    $data['profit_margin']   = $item['profit_margin'];
    $data['sales_price']     = $item['sales_price'];
    $data['final_price']     = $item['final_price'];
    $data['stock']           = $item['stock'];
    $data['lot_number']      = $item['lot_number'];
    $data['custom_barcode']  = $item['custom_barcode'];
    $data['discount']        = $item['discount'];
    $data['discount_type']   = $item['discount_type'];
    $data['expire_date']     = !empty($item['expire_date']) ? show_date($item['expire_date']) : '';

    return $data;
}

}
