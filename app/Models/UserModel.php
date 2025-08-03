<?php namespace App\Models;
  
use CodeIgniter\Model;
  
class UserModel extends Model{
    protected $table = 'db_users';
    protected $allowedFields = ['id', 'username', 'password', 'member_of', 'firstname', 'lastname', 'mobile', 'email', 'photo', 'gender', 'dob', 'country', 'state', 'city', 'address', 'postcode', 'role_name', 'role_id', 'profile_picture', 'created_date', 'created_time', 'created_by', 'system_ip', 'system_name', 'company_id', 'status'];



}

