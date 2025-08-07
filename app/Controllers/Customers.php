<?php
namespace App\Controllers;

class Customers extends BaseController
{

    // protected $GrantAccess;
    protected $userModel;
    protected $db;
    protected $coredata;
    protected $dashboardModel;
    protected $itemsModel;
    protected $purchaseModel;
    protected $customerModel;
    protected $session;

    function __construct()
    {
        $this->db = \Config\Database::connect();
        // $this->GrantAccess = service('grantAccess');
        $this->userModel = service('userModel');
        $this->coredata = service('coredata');
        $this->dashboardModel = service('dashboardModel');
        $this->itemsModel = service('itemsModel');
        $this->purchaseModel = service('purchaseModel');
        $this->customerModel = service('customerModel');
        $this->session = session();

    }


	public function index()
	{
		has_permission('customers_view');
		$data1 = $this->coredata->load_info();
		$data2 = $this->request->getPost();
		$data=array_merge($data1,$data2);
		$data['page_title']=lang('app.customers_list');
		$data['session']= $this->session;

		return view('customers-view',$data);
	}


	public function getCustomers($id = null)
	{
	    $cutomer = $this->customerModel
	    				->select('id, customer_name, mobile');
					    if (!empty($id)) {
					        $cutomer->where('id', $id);
					    } else{
					        $q = $this->request->getVar('searchTerm') ?? '';
					        $q = strtoupper($q);

					        if (!empty($q)) {
					            $cutomer->where("UPPER(customer_name) LIKE '%$q%' OR UPPER(mobile) LIKE '%$q%'");
					        }

					    }
	    				$cutomer = $cutomer->limit(10)->findAll();

	    $result = [];
	    foreach ($cutomer as $row) {
	        $result[] = [
	            'id'     => $row['id'],
	            'text'   => $row['customer_name'],
	            'mobile' => $row['mobile'],
	        ];
	    }

	    return $this->response->setJSON($result);
	}



	public function ajax_list()
	{
		$list = $this->customerModel->get_datatables();
		return $this->response->setJSON($list);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $customers) {
			$no++;
			$row = array();
			$disable = ($customers->id==1) ? 'disabled' : '';
			if($customers->id==1){
				$row[] = '<span class="text-blue">NA</span>';	
			}
			else{
				$row[] = '<input type="checkbox" name="checkbox[]" '.$disable.' value='.$customers->id.' class="checkbox column_checkbox" >';
			}
			
			$row[] = $customers->customer_code;
			$row[] = $customers->customer_name;
			$row[] = $customers->mobile;
			$row[] = $customers->email;
			$row[] = app_number_format($this->show_total_customer_paid_amount($customers->id));
			$row[] = (!empty($customers->sales_due) && $customers->sales_due!=0) ? app_number_format($customers->sales_due) : (0);
			$row[] = ($customers->sales_return_due==null) ? (0) : app_number_format($customers->sales_return_due);
			
			 		if($customers->status==1){ 
			 			$str= "<span onclick='update_status(".$customers->id.",0)' id='span_".$customers->id."'  class='label label-success' style='cursor:pointer'>Active </span>";}
					else{ 
						$str = "<span onclick='update_status(".$customers->id.",1)' id='span_".$customers->id."'  class='label label-danger' style='cursor:pointer'> Inactive </span>";
					}
			$row[] = $str;			
					$str2 = '<div class="btn-group" title="View Account">
										<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
											Action <span class="caret"></span>
										</a>
										<ul role="menu" class="dropdown-menu dropdown-light pull-right">';

											if($this->permissions('customers_edit')&& $customers->id!=1)
											$str2.='<li>
												<a title="Edit Record ?" href="customers/update/'.$customers->id.'">
													<i class="fa fa-fw fa-edit text-blue"></i>Edit
												</a>
											</li>';
											if($this->permissions('sales_payment_add'))
											$str2.='<li>
												<a title="Pay Opening Balance & Sales Due Payments" class="pointer" onclick="pay_now('.$customers->id.')" >
													<i class="fa fa-fw fa-money text-blue"></i>Receive Due Payments
												</a>
											</li>';
											if($this->permissions('sales_return_payment_add'))
											$str2.='<li>
												<a title="Pay Return Due" class="pointer" onclick="pay_return_due('.$customers->id.')" >
													<i class="fa fa-fw fa-money text-blue"></i>Pay Return Due
												</a>
											</li>';
											if($this->permissions('customers_delete') && $customers->id!=1)
											$str2.='<li>
												<a style="cursor:pointer" title="Delete Record ?" onclick="delete_customers('.$customers->id.')">
													<i class="fa fa-fw fa-trash text-red"></i>Delete
												</a>
											</li>
											
										</ul>
									</div>';			
			$row[] =  $str2;

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->customers->count_all(),
						"recordsFiltered" => $this->customers->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}






}
