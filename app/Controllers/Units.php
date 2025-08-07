<?php
namespace App\Controllers;

class Units extends BaseController
{

    // protected $GrantAccess;
    protected $userModel;
    protected $db;
    protected $coredata;
    protected $dashboardModel;
    protected $itemsModel;
    protected $purchaseModel;
    protected $unitModel;
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
        $this->unitModel = service('unitModel');
        $this->session = session();

    }

	public function add_unit_modal(){

        $validationRules = [
            'unit_name'       => ['label' => 'Unit Name', 'rules' => 'required|trim']
        ];

        if (!$this->validate($validationRules)) {
            return "Please Fill Compulsory(* marked) Fields.";
        }

        // Only get necessary and clean data
        $data = $this->request->getVar();

		$result=$this->verify_and_save($data);
		//fetch latest item details
		$res=[];
		$query=$this->unitModel->select("id,unit_name")->orderBy('id', 'desc')->first();
		$res['id']=$query['id'];
		$res['unit']=$query['unit_name'];
		$res['result']=$result;
		
		return json_encode($res);

	}


	public function verify_and_save($data){
		$unit = trim($data['unit_name'] ?? '');
		$description = trim($data['description'] ?? '');

		// Check for existing brand (case-insensitive)
		$existing = $this->unitModel
		    ->where('LOWER(unit_name)', strtolower($unit))
		    ->first();

		if ($existing) {
		    return 'This Unit Name already exists.';
		}

		// Generate brand code
		$maxRow = $this->unitModel
		    ->select('MAX(id) as maxid')
		    ->first();

		$maxid = ($maxRow['maxid'] ?? 0) + 1;
		$unitCode = 'CT' . str_pad($maxid, 4, '0', STR_PAD_LEFT);

		// Prepare insert data
		$insertData = [
		    'unit_code'  => $unitCode,
		    'unit_name'  => $unit,
		    'description' => $description,
		    'status'      => 1
		];

		// Insert into the database
		if ($this->unitModel->insert($insertData)) {
		    $this->session->setFlashdata('success', 'Success!! New Unit Added Successfully!');
		    return 'success';
		}

		return 'failed';
	}

	
}
