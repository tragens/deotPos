<?php namespace App\Models;
  
use CodeIgniter\Model;
  
class CustomerModel extends Model{
    protected $table = 'db_customers';
    protected $allowedFields = ['id', 'customer_code', 'customer_name', 'mobile', 'phone', 'email', 'gstin', 'tax_number', 'vatin', 'opening_balance', 'sales_due', 'sales_return_due', 'country_id', 'state_id', 'city', 'postcode', 'address', 'system_ip', 'system_name', 'created_date', 'created_time', 'created_by', 'company_id', 'status'];

    protected $table_as = 'db_customers as a';
    protected $column_order = array('a.customer_code','a.id','a.customer_name','a.mobile','a.email','a.status','a.sales_due','a.sales_return_due'); //set column field database for datatable orderable
    protected $column_search = array('a.customer_code','a.id','a.customer_name','a.mobile','a.email','a.status','a.sales_due','a.sales_return_due'); //set column field database for datatable searchable 
    protected $order = array('a.id' => 'desc'); // default order 



    public function get_datatables()
    {
        // Initialize the query builder
        $builder = $this->_get_datatables_query(); // 
        
        // Get the pagination parameters
        $length = service('request')->getPost('length');
        $start = service('request')->getPost('start');

        // Apply limit for pagination using the query builder
        if ($length != -1) {
            $builder->limit($length, $start);
        }

        // Execute the query and get the results
        $query = $builder->get();
        return $query->getResult(); // Return the result set
    }


    private function _get_datatables_query()
    {

        $i = 0;
        $builder = $this->db->table($this->table_as);
        $builder->select($this->column_order);
        // $builder->select("CASE WHEN e.brand_name IS NULL THEN '' ELSE e.brand_name END AS brand_name");
        // $builder->join('db_brands as e', 'e.id = a.brand_id', 'left');
        // $builder->join('db_category as b', 'b.id = a.category_id', 'left');
        // $builder->join('db_units as c', 'c.id = a.unit_id', 'left');
        // $builder->join('db_tax as d', 'd.id = a.tax_id', 'left');

        // Get filter parameters from POST
        $brand_id = service('request')->getPost('brand_id');
        $category_id = service('request')->getPost('category_id');
        
        // Apply filters if set
        if (!empty($brand_id)) {
            $builder->where("a.brand_id", $brand_id);
        }
        if (!empty($category_id)) {
            $builder->where("a.category_id", $category_id);
        }

        // Search filter
        $searchValue = service('request')->getPost('search')['value'] ?? '';
        if ($searchValue) {
            $i = 0;
            foreach ($this->column_search as $item) {
                if ($i === 0) {
                    $builder->groupStart();
                    $builder->like($item, $searchValue);
                } else {
                    $builder->orLike($item, $searchValue);
                }
                if (count($this->column_search) - 1 == $i) {
                    $builder->groupEnd();
                }
                $i++;
            }
        }

        // Order handling
        if (service('request')->getPost('order')) {
            $orderColumnIndex = service('request')->getPost('order')[0]['column'];
            $orderDirection = service('request')->getPost('order')[0]['dir'];
            $orderColumn = $this->column_order[$orderColumnIndex];
            $builder->orderBy($orderColumn, $orderDirection);
        } else if (isset($this->order)) {
            $order = $this->order;
            $builder->orderBy(key($order), $order[key($order)]);
        }
        return $builder;
    }


}

