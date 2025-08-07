<?php
namespace App\Controllers;

class Category extends BaseController
{

    // protected $GrantAccess;
    protected $userModel;
    protected $db;
    protected $coredata;
    protected $dashboardModel;
    protected $itemsModel;
    protected $purchaseModel;
    protected $categoryModel;
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
        $this->categoryModel = service('categoryModel');
        $this->session = session();

    }

	public function add_category_modal(){

        $validationRules = [
            'category'       => ['label' => 'Category Name', 'rules' => 'required|trim']
        ];

        if (!$this->validate($validationRules)) {
            return "Please Fill Compulsory(* marked) Fields.";
        }

        // Only get necessary and clean data
        $data = $this->request->getVar();

		$result=$this->verify_and_save($data);
		//fetch latest item details
		$res=[];
		$query=$this->categoryModel->select("id,category_name")->orderBy('id', 'desc')->first();
		$res['id']=$query['id'];
		$res['category']=$query['category_name'];
		$res['result']=$result;
		
		return json_encode($res);

	}


	public function verify_and_save($data){
		$category = trim($data['category'] ?? '');
		$description = trim($data['description'] ?? '');

		// Check for existing brand (case-insensitive)
		$existing = $this->categoryModel
		    ->where('LOWER(category_name)', strtolower($category))
		    ->first();

		if ($existing) {
		    return 'This Category Name already exists.';
		}

		// Generate brand code
		$maxRow = $this->categoryModel
		    ->select('MAX(id) as maxid')
		    ->first();

		$maxid = ($maxRow['maxid'] ?? 0) + 1;
		$categoryCode = 'CT' . str_pad($maxid, 4, '0', STR_PAD_LEFT);

		// Prepare insert data
		$insertData = [
		    'category_code'  => $categoryCode,
		    'category_name'  => $category,
		    'description' => $description,
		    'status'      => 1
		];

		// Insert into the database
		if ($this->categoryModel->insert($insertData)) {
		    $this->session->setFlashdata('success', 'Success!! New Category Added Successfully!');
		    return 'success';
		}

		return 'failed';
	}

	
}
