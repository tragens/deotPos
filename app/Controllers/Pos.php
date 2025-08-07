<?php
namespace App\Controllers;

class Pos extends BaseController
{

    // protected $GrantAccess;
    protected $userModel;
    protected $db;
    protected $coredata;
    protected $customerModel;
    protected $itemsModel;
    protected $posModel;
    protected $holdModel;
    protected $session;
    protected $countryModel;
    protected $statesModel;
    protected $taxModel;
    protected $paymenttypesModel;
    protected $sitesettingsModel;
    protected $categoryModel;
    protected $brandModel;
    protected $companyModel;

    function __construct()
    {
        $this->db = \Config\Database::connect();
        // $this->GrantAccess = service('grantAccess');
        $this->userModel = service('userModel');
        $this->coredata = service('coredata');
        $this->customerModel = service('customerModel');
        $this->itemsModel = service('itemsModel');
        $this->posModel = service('posModel');
        $this->holdModel = service('holdModel');
        $this->session = session();
        $this->countryModel = service('countryModel');
        $this->statesModel = service('statesModel');
        $this->taxModel = service('taxModel');
        $this->paymenttypesModel = service('paymenttypesModel');
        $this->sitesettingsModel = service('sitesettingsModel');
        $this->categoryModel = service('categoryModel');
        $this->brandModel = service('brandModel');
        $this->companyModel = service('companyModel');

    }

	public function index()
	{
		has_permission('pos');
		$data1=$this->coredata->load_info();
		$data2 = $this->request->getPost();
		$data=array_merge($data1,$data2);
		$data['page_title']='POS';
		$data['result'] = $this->get_hold_invoice_list();
		$data['tot_count'] = $this->get_hold_invoice_count();
		$data['session'] = $this->session;
		$data['country'] = $this->countryModel->where('status', 1)->findAll();
		$data['states'] = $this->statesModel->where('status', 1)->findAll();
		$data['tax'] = $this->taxModel->where('status', 1)->findAll();
		$data['paytypes'] = $this->paymenttypesModel->where('status', 1)->findAll();
		$data['sales_discount'] = $this->sitesettingsModel->select('sales_discount')->first()['sales_discount'];
        $data['category'] = $this->categoryModel->where('status', 1)->findAll();
        $data['brands'] = $this->brandModel->where('status', 1)->findAll();
		return view('pos',$data);
	}

	public function get_hold_invoice_list(){
		$data = [];
		$result= $this->posModel->hold_invoice_list();
		return $result;
	}

	public function get_hold_invoice_count(){
		return $this->holdModel->countAllResults();
	}


    //adding new item from Modal
    public function newcustomer(){

        $validationRules = [
            'customer_name'       => ['label' => 'Customer Name', 'rules' => 'required|trim'],
        ];

        if (!$this->validate($validationRules)) {
            return "Please Fill Compulsory(* marked) Fields.";
        }

        // Only get necessary and clean data
        $data = $this->request->getVar();
        $result = $this->verify_and_save($data);
        $res=[];
        $query=$this->customerModel
                    ->select("id,customer_name")
                    ->orderBy('id', 'desc')
                    ->first();

        $res['id']=$query['id'];
        $res['customer_name']=$query['customer_name'];
        $res['result']=$result;            

        return json_encode($res);

    }



public function verify_and_save($data)
{
    $from_core = $this->coredata->load_info();

    // Check if mobile number already exists for the same company
    $existingCustomer = $this->customerModel
        ->where('mobile', $data['mobile'])
        ->first();

    if ($existingCustomer) {
        return "Sorry! This Mobile Number already exists.";
    }

    // Get customer init prefix
    $company = $this->companyModel->select('customer_init')->first();
    $customer_init = $company['customer_init'] ?? 'CUST';

    // Generate new customer_code
    $lastCustomer = $this->customerModel->select('id')->orderBy('id', 'DESC')->first();
    $nextId = $lastCustomer['id'] ?? 0;
    $nextId++;
    $customer_code = $customer_init . str_pad($nextId, 4, '0', STR_PAD_LEFT);

    // Begin DB transaction
    $this->db->transStart();

    $insertData = [
        'customer_code'    => $customer_code,
        'customer_name'    => $data['customer_name'],
        'mobile'           => $data['mobile'],
        'phone'            => $data['phone'],
        'email'            => $data['email'],
        'gstin'            => $data['gstin'],
        'tax_number'       => $data['tax_number'],
        'country_id'       => $data['country'],
        'state_id'         => $data['state'] ?? null,
        'city'             => $data['city'],
        'postcode'         => $data['postcode'],
        'address'          => $data['address'],
        'opening_balance'  => $data['opening_balance'] ?? 0,
        'system_ip'        => $this->request->getIPAddress(),
        'system_name'      => php_uname('n'),
        'created_date'     => $from_core['CUR_DATE'],
        'created_time'     => $from_core['CUR_TIME'],
        'created_by'       => $this->session->get('inv_username'),
        'status'           => 1,
    ];


    $customerId = $this->customerModel->insert($insertData);

    if (!$customerId) {
        // $this->db->transRollback();
        $error = $this->customerModel->error();
        $error = $this->customerModel->getLastQuery();
        return var_dump($error);
    }

    $this->db->transCommit();

    session()->setFlashdata('success', 'Success! New Customer added successfully.');
    return 'success';
}




    public function get_details(){
          $i=0;
          $str='';
          $table='';
          $data = $this->request->getVar();
          
          // $q2 = $this->itemsModel->select("b.id as tax_id, a.*,b.tax,b.tax_name")
          //       ->from("db_items a")
          //       ->join("db_tax b","b.id=a.tax_id","left")
          //       ->where("a.status", 1);
          $q2 = $this->itemsModel->select("db_items.*, b.id as tax_id, b.tax,b.tax_name")
                ->join("db_tax b","b.id=db_items.tax_id","left")
                ->where("db_items.status", 1);
          if(!empty($data['id'])){
                $q2->where("db_items.category_id",$data['id']);
          }
          if($data['brand_id']!=''){
                $q2->where("db_items.brand_id", $data['brand_id']);
          }
          if(isset($data['last_id']) && !empty($data['last_id'])){
                $q2->where("db_items.id>".$data['last_id']);
          }
          if(!empty($data['item_name'])){
                $q2->where("upper(db_items.item_name) like upper('%".$data['item_name']."%')");
          }
          $q2=$q2->limit(30)->findAll();

          // return $this->response->setJSON($q2);

          $last_id = '';
          if($q2){
            foreach($q2 as $res2){
                $item_tax_type = $res2['tax_type'];
                $item_tax_id = $res2['tax_id'];
                $item_sales_price = $res2['sales_price'];
                $item_cost = $res2['purchase_price'];
                $item_tax = $res2['tax'];
                $item_tax_name = $res2['tax_name'];
                $purchase_price = $res2['purchase_price'];
                $discount_type = $res2['discount_type'];
                $discount = $res2['discount'];
                $item_sales_qty = 1;

                //Check Exculsive or Inclusive
                if($item_tax_type=='Exclusive'){
                    //$single_unit_price = $item_sales_price;
                    //$item_sales_price=$item_sales_price+ (($item_sales_price*$item_tax)/100);
                    //$item_tax_amt = (($single_unit_price * $item_sales_qty)*$item_tax)/100;
                }
                else{//Inclusive    
                    //$item_tax_amt=number_format($this->inclusive($item_sales_price,$item_tax),2,'.','');
                    //$single_unit_price = $item_sales_price;
                }

                $item_tax_amt = ($item_tax_type=='Inclusive') ? calculate_inclusive($item_sales_price,$item_tax) :calculate_exclusive($item_sales_price,$item_tax);

                //$item_amount = ($item_sales_price * $item_sales_qty) + $item_tax_amt;
                //end 

                if($res2['stock'] <=0){
                    $str="zero_stock()";
                    $disabled='';
                    $bg_color="background-color:#c8c8c8";
                }
                else{
                    $str="addrow({$res2['id']})";
                    $disabled="disabled=disabled";
                    $bg_color="background-color:#a1db75";
                }

                $img_src = (!empty($res2['item_image']) && file_exists($res2['item_image'])) ? base_url(return_item_image_thumb($res2['item_image'])) : base_url('theme/images/no_image.png');

                $table .= '<div class="col-md-3 col-xs-6 " id="item_parent_'.$i.'" '.$disabled.' data-toggle="tooltip" title="'.$res2['item_name'].'" style="padding-left:5px;padding-right:5px;">
              <div class="box box-default item_box" id="div_'.$res2['id'].'" onclick="'.$str.'"
                            data-item-id="'.$res2['id'].'"
                            data-item-name="'.$res2['item_name'].'"
                            data-item-available-qty="'.$res2['stock'].'"
                            data-item-sales-price="'.$item_sales_price.'"
                            data-item-cost="'.$item_cost.'"
                            data-item-tax-id="'.$item_tax_id.'"
                            data-item-tax-type="'.$item_tax_type.'"
                            data-item-tax-value="'.$item_tax.'"
                            data-item-tax-name="'.$item_tax_name.'"
                            data-item-tax-amt="'.$item_tax_amt.'"
                            data-purchase_price="'.$purchase_price.'"
                            data-discount_type="'.$discount_type.'"
                            data-discount="'.$discount.'"
                            style="max-height: 150px;min-height: 150px;cursor: pointer;'.$bg_color.'">
                <span class="label label-danger push-right" style="font-weight: bold;font-family: sans-serif;" data-toggle="tooltip" title="'.$res2['stock'].' Quantity in Stock">Qty: '.$res2['stock'].'</span>
                <div class="box-body box-profile">
                    <center>
                    <img class=" img-responsive item_image" style="border: 1px solid gray;"  src="'.$img_src.'" alt="Item picture">
                  </center>
                  <lable class="text-center search_item" style="font-weight: bold;font-family: sans-serif;" id="item_'.$i.'">'.substr($res2['item_name'],0,25).'</label><br>
                  <span class="" style="font-family: sans-serif;font-size:150%; " >'.$item_sales_price.'
                  </span>
                </div>
              </div>
            </div>';
              $i++;
//                   <span class="" style="font-family: sans-serif;font-size:150%; " >'.currency(number_format($item_sales_price)).'

              $last_id = $res2['id'];
              }//for end
              $table.='<input type="hidden" class="last_id" id="'.$last_id.'" />';
              return $table;
          }//if num_rows() end
         
    }

public function get_item_details()
{
    $item_id = $this->request->getVar('item_id');
    $res1 = $this->itemsModel->select("b.id as tax_id, a.*, b.tax, b.tax_name, a.tax_type, a.sales_price")
        ->from("db_items a")
        ->join("db_tax b", "b.id=a.tax_id", "left")
        ->where(["a.status" => 1, "a.id" => $item_id])
        ->first();

    if (!$res1) {
        return json_encode(['error' => 'Item not found']);
    }

    $item_tax_amt = ($res1['tax_type'] == 'Inclusive') 
        ? calculate_inclusive($res1['sales_price'], $res1['tax']) 
        : calculate_exclusive($res1['sales_price'], $res1['tax']);

    $item_array = array(
        'id'             => $res1['id'],
        'item_name'      => $res1['item_name'],
        'stock'          => $res1['stock'],
        'sales_price'    => $res1['sales_price'],
        'purchase_price' => $res1['purchase_price'],
        'tax_id'         => $res1['tax_id'],
        'tax_type'       => $res1['tax_type'],
        'tax'            => $res1['tax'],
        'tax_name'       => $res1['tax_name'],
        'item_tax_amt'   => round($item_tax_amt, 2),
        'discount_type'  => $res1['discount_type'],
        'discount'       => $res1['discount'],
    );

    return json_encode($item_array);
}











































public function pos_save_update()
{


    // public function pos_save_update(){
    //     $result='';
    //     if($this->input->post('command')=='update'){//Update
    //         $result = $this->pos_model->pos_save_update();
    //     }
    //     else{//Save
    //         $result = $this->pos_model->pos_save_update();
    //         //$result =$result."<<<###>>>".$this->pos_model->get_details();
    //         $result =$result."<<<###>>>".$this->pos_model->hold_invoice_list();
    //         $q1=$this->db->query("SELECT * FROM db_hold");
    //         $data['tot_count']=$q1->num_rows();
    //         $result =$result."<<<###>>>".$q1->num_rows();
    //     }
        
    //     echo $result;exit();
    // }









    $db = \Config\Database::connect();
    $request = service('request');
    $session = session();
    $data = esc($request->getVar());

    $db->transStart();

    try {
        $sales_id = $this->saveOrUpdateSale($data);

        $this->saveSaleItems($sales_id, $data);
        $this->handlePayments($sales_id, $data);
        $this->salesModel->update_sales_payment_status($sales_id, $data['customer_id'] ?? null);

        if (!empty($data['hidden_invoice_id'])) {
            $this->hold_invoice_delete($data['hidden_invoice_id']);
        }

        if (!empty($data['send_sms']) && ($data['customer_id'] ?? 1) != 1) {
            $sms_success = send_sms_using_template($sales_id, 1);
            $session->setFlashdata('success', $sms_success ? 'SMS sent successfully!' : 'Failed to send SMS');
        } else {
            $session->setFlashdata('success', 'Success!! Sales Created Successfully!');
        }

        $db->transComplete();

        return "success<<<###>>>$sales_id";

    } catch (\Exception $e) {
        $db->transRollback();
        return $this->failServerError('Transaction failed: ' . $e->getMessage());
    }
}


private function saveOrUpdateSale(array $data)
{
    $sales_date = isset($data['sales_date']) ? date('Y-m-d', strtotime($data['sales_date'])) : date('Y-m-d');
    $tot_grand = $data['tot_grand'] ?? 0;
    $tot_amt = $data['tot_amt'] ?? 0;
    $round_off = number_format((float)$tot_grand - (float)$tot_amt, 2, '.', '');

    $entry = [
        'sales_date' => $sales_date,
        'sales_status' => 'Final',
        'customer_id' => $data['customer_id'] ?? null,
        'discount_to_all_input' => $data['discount_input'] ?? null,
        'discount_to_all_type' => $data['discount_type'] ?? null,
        'tot_discount_to_all_amt' => $data['tot_disc'] ?? null,
        'other_charges_input' => $data['other_charges'] ?? null,
        'other_charges_amt' => $data['other_charges'] ?? null,
        'subtotal' => $tot_amt,
        'round_off' => $round_off,
        'grand_total' => $tot_grand,
    ];

    if (!empty($data['command']) && $data['command'] === 'update') {
        $sales_id = $data['sales_id'];
        $this->salesModel->update($sales_id, $entry);

        $this->salesitemModel->where('sales_id', $sales_id)->delete();
        $this->salespaymentModel->where('sales_id', $sales_id)->delete();

        return $sales_id;
    }

    // Generate sales_code
    $init = $this->companyModel->select('sales_init')->where('id', 1)->first()['sales_init'] ?? '';
    $maxid = $this->salesModel->builder()->selectMax('id')->get()->getRow()->id ?? 0;
    $sales_code = $init . str_pad($maxid + 1, 4, '0', STR_PAD_LEFT);

    $entry += [
        'sales_code' => $sales_code,
        'created_date' => date('Y-m-d'),
        'created_time' => date('H:i:s'),
        'created_by' => $data['CUR_USERNAME'] ?? 'system',
        'system_ip' => $data['SYSTEM_IP'] ?? '0.0.0.0',
        'system_name' => $data['SYSTEM_NAME'] ?? '',
        'pos' => 1,
        'status' => 1,
    ];

    $this->salesModel->insert($entry);
    return $this->salesModel->insertID();
}


private function saveSaleItems(int $sales_id, array $data): void
{
    $rowcount = $data['hidden_rowcount'] ?? 0;

    for ($i = 0; $i < $rowcount; $i++) {
        if (empty($data["tr_item_id_$i"])) continue;

        $item_id = $data["tr_item_id_$i"];
        $sales_qty = $data["item_qty_$item_id"];
        $price_per_unit = $data["sales_price_$i"];
        $tax_amt = $data["td_data_{$i}_11"] ?? null;
        $tax_type = $data["tr_tax_type_$i"];
        $tax_id = $data["tr_tax_id_$i"] ?? null;
        $tax_value = $data["tr_tax_value_$i"];
        $total_cost = $data["td_data_{$i}_4"] ?? null;
        $description = $data["description_$i"] ?? '';
        $purchase_price = $data["purchase_price_$i"] ?? 0;
        $discount_type = $data["item_discount_type_$i"] ?? '';
        $discount_input = $data["item_discount_input_$i"] ?? '';
        $discount_amt = $data["item_discount_$i"] ?? 0;

        $discount_per_unit = ($sales_qty != 0) ? $discount_amt / $sales_qty : 0;
        $unit_total_cost = ($tax_type == 'Exclusive')
            ? $price_per_unit + ($price_per_unit * $tax_value / 100)
            : $price_per_unit;
        $unit_total_cost -= $discount_per_unit;

        $entry = [
            'sales_id' => $sales_id,
            'sales_status' => 'Final',
            'item_id' => $item_id,
            'description' => $description,
            'sales_qty' => $sales_qty,
            'price_per_unit' => $price_per_unit,
            'tax_id' => $tax_id ?: null,
            'tax_amt' => $tax_amt ?: null,
            'tax_type' => $tax_type,
            'discount_type' => $discount_type,
            'discount_input' => $discount_input,
            'discount_amt' => $discount_amt,
            'unit_total_cost' => $unit_total_cost,
            'total_cost' => $total_cost,
            'purchase_price' => $purchase_price,
            'status' => 1,
        ];

        $this->salesitemModel->insert($entry);
        $this->update_items_quantity($item_id); // Update item stock
    }
}


private function handlePayments(int $sales_id, array $data): void
{
    $payment_row_count = $data['payment_row_count'] ?? 1;
    $pay_all = $data['pay_all'] ?? 'false';
    $by_cash = $pay_all === 'true';

    for ($i = 1; $i <= $payment_row_count; $i++) {
        $amount = $data["amount_$i"] ?? null;

        if (empty($amount) && !$by_cash) {
            continue;
        }

        if ($by_cash) {
            $amount = $data['tot_grand'] ?? 0;
            $payment_type = 'Cash';
            $payment_note = 'Paid By Cash';
        } else {
            $payment_type = $data["payment_type_$i"];
            $payment_note = $data["payment_note_$i"];
        }

        $change_return = 0;
        if ($amount > ($data['tot_grand'] ?? 0)) {
            $change_return = $amount - $data['tot_grand'];
            $amount = $data['tot_grand'];
        }

        $entry = [
            'sales_id' => $sales_id,
            'payment_date' => date('Y-m-d'),
            'payment_type' => $payment_type,
            'payment' => $amount,
            'payment_note' => $payment_note,
            'created_date' => date('Y-m-d'),
            'created_time' => date('H:i:s'),
            'created_by' => $data['CUR_USERNAME'] ?? 'system',
            'system_ip' => $data['SYSTEM_IP'] ?? '0.0.0.0',
            'system_name' => $data['SYSTEM_NAME'] ?? '',
            'change_return' => $change_return,
            'status' => 1,
        ];

        $this->salespaymentModel->insert($entry);
    }
}






	
}
