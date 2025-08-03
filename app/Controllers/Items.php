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

	public function index()
	{
		$this->coredata->permission_check('items_view');
		$data1 = $this->coredata->load_info();
		$data2 = $this->request->getPost();
		$data=array_merge($data1,$data2);
		$data['session'] = \Config\Services::session();
		$data['page_title'] = lang('items_list');
		return view('items-list',$data);
	}
	
}
