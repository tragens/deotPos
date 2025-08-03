<?php
namespace App\Controllers;

class Login extends BaseController
{

    // protected $GrantAccess;
    protected $userModel;
    protected $db;
    protected $coredata;

    function __construct()
    {
		$this->php_verification();
        $this->db = \Config\Database::connect();
        // $this->GrantAccess = service('grantAccess');
        $this->userModel = service('userModel');
        $this->coredata = service('coredata');


    }

	protected function php_verification()
	{
	    // if (PHP_VERSION_ID < 70400 || PHP_VERSION_ID >= 70500) {
	    if (PHP_VERSION_ID < 70400) {
	        exit('Application requires PHP Version 7.4.*, but your server is running PHP Version ' . PHP_VERSION);
	    }
	    //redirected to error page with that message
	}

	public function index()
	{
	    // Check if the user is already logged in
	    if (session()->get('logged_in') === true) {
	        return redirect()->to(base_url('dashboard'));
	    }

	    $data = $this->coredata->load_info();
	    // Load the login view with data
	    return view('login', $data);
	}


	public function verify()
	{
	    helper(['form']); // Ensure form helper is loaded

	    // Set validation rules with custom field labels
	    $validationRules = [
	        'username' => [
	            'label' => 'Username',
	            'rules' => 'required'
	        ],
	        'pass' => [
	            'label' => 'Password',
	            'rules' => 'required'
	        ]
	    ];

	    if (!$this->validate($validationRules)) {
	        // Set flashdata if validation fails
	        session()->setFlashdata('msg', 'Please enter username & password!');
	        return redirect()->to(base_url('login'))->withInput();
	    }

	    // Get sanitized input
	    $username = esc($this->request->getVar('username'));
	    $password = esc($this->request->getVar('pass'));

	    // Query the user
	    $user = $this->userModel
	        ->select('db_users.id, db_users.username, db_users.role_id, db_roles.role_name')
	        ->join('db_roles', 'db_roles.id = db_users.role_id')
	        ->where([
	            'db_users.username' => $username,
	            'db_users.password' => md5($password), // Not recommended for real apps
	            'db_users.status'   => 1
	        ])
	        ->first();

	    if ($user) {
	        // Set session data
	        $sessionData = [
	            'inv_username' => $user['username'],
	            'inv_userid'   => $user['id'],
	            'logged_in'    => true,
	            'role_id'      => $user['role_id'],
	            'role_name'    => trim($user['role_name'])
	        ];

	        session()->set($sessionData);
	        session()->setFlashdata('success', 'Welcome ' . ucfirst($user['username']) . '!');
	        return redirect()->to(base_url('dashboard'));
	    } else {
	        session()->setFlashdata('msg', 'Invalid Username & Password.');
	        return redirect()->to(base_url('login'));
	    }
	}

	// public function forgot_password(){
	// 	if($this->session->userdata('logged_in')==1){ redirect(base_url().'dashboard','refresh');	}
	// 	$data = $this->data;
	// 	$this->load->view('forgot-password',$data);
	// }
	// /*public function send_otp(){		
	// 	$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		
	// 	if($this->form_validation->run()==FALSE){
	// 		$this->session->set_flashdata('failed', 'Invalid Email!');
	// 		redirect(base_url().'login/forgot_password');
	// 	}
	// 	else{
	// 		$email=$this->input->post('email');
	// 		$this->load->model('login_model');//Model
	// 		if($this->login_model->verify_email_send_otp($email)){//Model->Method
	// 			redirect(base_url().'login/otp');
	// 		}
	// 		else{
	// 			$this->session->set_flashdata('failed', 'Invalid Email!!');
	// 			redirect(base_url().'login/forgot_password');
	// 		}			
	// 	}
	// }*/
	// public function send_otp(){		
	// 	$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		
	// 	if($this->form_validation->run()==FALSE){
	// 		$this->session->set_flashdata('failed', 'Invalid Email!');
	// 		redirect(base_url().'login/forgot_password');
	// 	}
	// 	else{
	// 		$email=$this->input->post('email');
	// 		$this->load->model('login_model');//Model
	// 		$response = $this->login_model->verify_email_send_otp($email);

	// 		if($response==true){//Model->Method
	// 			redirect(base_url().'login/otp');
	// 		}
	// 		else{
	// 			//$this->session->set_flashdata('failed', 'Invalid Email!!');
	// 			redirect(base_url().'login/forgot_password');
	// 		}			
	// 	}
	// }
	// public function otp(){
	// 	if($this->session->userdata('logged_in')==1){ redirect(base_url().'dashboard','refresh');	}
	// 	$data = $this->data;
	// 	$this->load->view('otp',$data);
	// }
	// public function verify_otp(){
	// 	$this->form_validation->set_rules('otp', 'OTP', 'required');
	// 	$this->form_validation->set_rules('email', 'Email', 'required');
		
	// 	if($this->form_validation->run()==FALSE){
	// 		$this->session->set_flashdata('failed', 'Invalid OTP!');
	// 		redirect(base_url().'login/otp');
	// 	}
	// 	else{
	// 		$otp=$this->input->post('otp');
	// 		$email=$this->input->post('email');
			
	// 		if($this->session->userdata('email')==$email && $this->session->userdata('otp')==$otp){
	// 			$data=$this->data;
	// 			$data['email']=$email;
	// 			$data['otp']=$otp;
				
	// 			$this->load->view("change-login-password",$data);
	// 		}
	// 		else{
	// 			$this->session->set_flashdata('failed', 'Invalid OTP!!');
	// 			redirect(base_url().'login/otp');
	// 		}			
	// 	}
	// }
	// public function change_password(){

	// 	$this->form_validation->set_rules('otp', 'OTP', 'required');
	// 	$this->form_validation->set_rules('email', 'Email', 'required');
	// 	$this->form_validation->set_rules('password', 'Password', 'required');
	// 	$this->form_validation->set_rules('cpassword', 'Confirm Password', 'required');
		
	// 	//print_r($_POST);exit;
	// 	if($this->form_validation->run()==FALSE){
	// 		$this->session->set_flashdata('failed', 'Please Enter Correct Passwords!');
	// 		redirect(base_url().'login/verify_otp');
	// 	}
	// 	else{
	// 		$otp=$this->input->post('otp');
	// 		$email=$this->input->post('email');
	// 		$password=$this->input->post('password');
	// 		$cpassword=$this->input->post('cpassword');
	// 		$this->load->model('login_model');//Model
	// 		if($password==$cpassword && $this->session->userdata('email')==$email && $this->session->userdata('otp')==$otp){
	// 			if($this->login_model->change_password($password,$email)){//Model->Method
	// 				$data = $this->data;
	// 				$array_items = array('email','otp');
	// 				$this->session->unset_userdata($array_items);
	// 				$this->session->set_flashdata('success', 'Password Changed Successfully!');
	// 				redirect(base_url().'login','refresh');
	// 			}
	// 			else{
	// 				$this->session->set_flashdata('failed', 'Please Enter Correct Passwords!');
	// 				redirect(base_url().'login/verify_otp');
	// 			}			
	// 		}
	// 	}

	// }
	
	public function logout()
	{
		// $data = $this->data;
		/*$array_items = array('inv_username','inv_userid','logged_in','permissions','currency');
		$this->session->unset_userdata($array_items);*/

		//DELETE THE EXPIRED SESSION FROM SESSION, WHICH SAVED
		// $this->db->where("timestamp<=",time()-config_item('sess_expiration'))->delete(config_item('sess_save_path'));
		// //CLEAR ALL SESSION FROM VIRTUAL VARIABLES
          
        $session = session();
            $session->destroy();            
		//LOGOUT
            return redirect()->to(base_url('login'));
	}


}
