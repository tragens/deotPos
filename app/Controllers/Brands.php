<?php
namespace App\Controllers;

class Brands extends BaseController
{

    // protected $GrantAccess;
    protected $userModel;
    protected $db;
    protected $coredata;
    protected $dashboardModel;
    protected $itemsModel;
    protected $purchaseModel;
    protected $brandModel;
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
        $this->brandModel = service('brandModel');
        $this->session = session();

    }

	public function add_brand_modal(){

        $validationRules = [
            'brand'       => ['label' => 'Brand Name', 'rules' => 'required|trim']
        ];

        if (!$this->validate($validationRules)) {
            return "Please Fill Compulsory(* marked) Fields.";
        }

        // Only get necessary and clean data
        $data = $this->request->getVar();

		$result=$this->verify_and_save($data);
		//fetch latest item details
		$res=[];
		$query=$this->brandModel->select("id,brand_name")->orderBy('id', 'desc')->first();
		$res['id']=$query['id'];
		$res['brand']=$query['brand_name'];
		$res['result']=$result;
		
		return json_encode($res);

	}


	public function verify_and_save($data){
		$brand = trim($data['brand'] ?? '');
		$description = trim($data['description'] ?? '');

		// Check for existing brand (case-insensitive)
		$existing = $this->brandModel
		    ->where('LOWER(brand_name)', strtolower($brand))
		    ->first();

		if ($existing) {
		    return 'This Brand Name already exists.';
		}

		// Generate brand code
		$maxRow = $this->brandModel
		    ->select('MAX(id) as maxid')
		    ->first();

		$maxid = ($maxRow['maxid'] ?? 0) + 1;
		$brandCode = 'CT' . str_pad($maxid, 4, '0', STR_PAD_LEFT);

		// Prepare insert data
		$insertData = [
		    'brand_code'  => $brandCode,
		    'brand_name'  => $brand,
		    'description' => $description,
		    'status'      => 1
		];

		// Insert into the database
		if ($this->brandModel->insert($insertData)) {
		    $this->session->setFlashdata('success', 'Success!! New Brand Added Successfully!');
		    return 'success';
		}

		return 'failed';
	}

	
}
