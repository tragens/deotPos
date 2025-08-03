<?php
namespace App\Controllers;

class Dashboard extends BaseController
{

    // protected $GrantAccess;
    protected $userModel;
    protected $db;
    protected $coredata;
    protected $dashboardModel;

    function __construct()
    {
        $this->db = \Config\Database::connect();
        // $this->GrantAccess = service('grantAccess');
        $this->userModel = service('userModel');
        $this->coredata = service('coredata');
        $this->dashboardModel = service('dashboardModel');


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
		$data['page_title']=lang('dashboard');
		$data['language'] = $this->request->getPost('language');
		$data['permission'] = $this->coredata->permissions();
		$data['session'] = \Config\Services::session();

// return		var_dump($this->coredata->permissions('expired_items_report'));
		
		if(!$this->coredata->permissions('dashboard_view')){
			$this->load->view('role/dashboard_empty',$data);
		}
		else{ return view('dashboard',$data); }
		
	}
	
}
