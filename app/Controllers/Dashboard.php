<?php
namespace App\Controllers;

class Dashboard extends BaseController
{

    // protected $GrantAccess;
    protected $userModel;
    protected $db;
    protected $coredata;
    protected $dashboardModel;
    protected $itemsModel;
    protected $purchaseModel;
    protected $salesModel;

    function __construct()
    {
        $this->db = \Config\Database::connect();
        // $this->GrantAccess = service('grantAccess');
        $this->userModel = service('userModel');
        $this->coredata = service('coredata');
        $this->dashboardModel = service('dashboardModel');
        $this->itemsModel = service('itemsModel');
        $this->purchaseModel = service('purchaseModel');
        $this->salesModel = service('salesModel');
    }

	public function test(){
		$this->permission_check('items_category_add');
		$data=$this->data;
		$data['page_title']=$this->lang->line('category');
		$this->load->view('test.php', $data);
	}
	public function index()
	{	

		$data1=$this->coredata->load_info();
        $data2 = $this->dashboardModel->breadboard_values();
		$data3 = $this->request->getPost();
		$data=array_merge($data1,$data2, $data3);
		$data['page_title']=lang('app.dashboard');
		$data['language'] = $this->request->getPost('language');
		$data['permission'] = $this->coredata->permissions();
		$data['session'] = \Config\Services::session();
		$data['recently_added_items'] = $this->itemsModel
											->select('item_name,sales_price')
											->where('status', 1)
											->orderBy('id', 'DESC')
											->limit(5)->findAll();
		
		$data['expired_items'] = $this->itemsModel
									->select('db_items.item_name,db_items.item_code,b.category_name,db_items.expire_date')
									->join('db_category as b', 'b.id = db_items.category_id')
									->where(['db_items.status'=> 1, 'db_items.expire_date <=' => date("Y-m-d")])
									->orderBy('db_items.id', 'DESC')
									->limit(10)->findAll();
		
		$data['stock_alert'] = $this->itemsModel
									->select('b.category_name,db_items.item_name,db_items.stock')
									->join('db_category as b', 'b.id = db_items.category_id', 'left')
								    ->where('db_items.status', 1)
								    ->where('db_items.stock <= db_items.alert_qty')
									->orderBy('db_items.id', 'DESC')
									->limit(10)->findAll();
		
		$data['bar_chart'] = $this->purchaseModel
									->select('COALESCE(SUM(grand_total),0) AS pur_total,MONTH(purchase_date) AS purchase_date')
								    ->where('purchase_status', 'Received')
								    ->where('YEAR(purchase_date)', date('Y'))
								    ->groupBy('MONTH(purchase_date)')
									->findAll();
		
		$data['donus_chart'] = $this->salesModel
									->select('COALESCE(SUM(grand_total),0) AS sal_total,MONTH(sales_date) AS sales_date')
								    ->where('sales_status', 'Final')
								    ->where('YEAR(sales_date)', date('Y'))
								    ->groupBy('MONTH(sales_date)')
									->findAll();
		
		$data['pie_chart'] = $this->itemsModel
									->select('COALESCE(SUM(b.sales_qty),0) AS sales_qty, db_items.item_name')
									->join('db_salesitems as b', 'b.item_id = db_items.id')
									->join('db_sales as c', 'c.id = b.sales_id')
								    ->where('c.sales_status', 'Final')
								    ->groupBy('db_items.id')
									->limit(10)->findAll();
		

		if(!$this->coredata->permissions('dashboard_view')){
			$this->load->view('role/dashboard_empty',$data);
		}
		else{ return view('dashboard',$data); }
		
	}
	
}
