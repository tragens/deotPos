<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class CommonData implements FilterInterface
{

    // Declare properties for each model
    protected $userModel;
    // protected $sidebarModel;
    // protected $messageModel;
    // protected $nhifModel;
    // protected $sitesettingsModel;
    // protected $getDeviceType;
    // protected $getDeviceOS;

    public function __construct()
    {
        // Initialize each model using a service function
        $this->userModel = service('userModel');
        // $this->sidebarModel = service('sidebarModel');
        // $this->messageModel = service('messageModel');
        // $this->nhifModel = service('nhifModel');
        // $this->sitesettingsModel = service('sitesettingsModel');
        // Capture the device-related information
        // $deviceInfo = $this->getDeviceInfo();
        // $this->deviceType = $deviceInfo['deviceType'];
        // $this->deviceIp = $deviceInfo['deviceIp'];
        // $this->deviceOs = $deviceInfo['deviceOs'];

    }


    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        
        $session = session();
        $data = [];

        // $data['site'] = $this->sitesettingsModel->first();

        // if ($session->has('username')) {
            $data['userId'] = $session->get('inv_userid');
        //     $data['username'] = $session->get('username');

        //     // $user = $this->userModel->find($data['userId']);
        //     // Cache user data if necessary
        //     if (!$session->has('user_data')) {
        //         $userData = $this->userModel->find($data['userId']);
        //         $session->set('user_data', $userData);
        //     } else {
        //         $userData = $session->get('user_data');
        //     }

        //     if ($userData) {
        //         // Permissions and user information
        //         $permissions = [
        //             'permission' => explode(',', $userData['permission']),
        //             'create' => explode(',', $userData['creator']),
        //             'edit' => explode(',', $userData['edit']),
        //             'auth' => explode(',', $userData['auth']),
        //             'delete' => explode(',', $userData['deletor']),
        //             'approve' => explode(',', $userData['approve']),
        //             'location_access' => explode(',', $userData['location']),
        //         ];
        //         $data = array_merge($data, $permissions);

        //         $data['access'] = ["fname" => $userData['fname'], "mname" => $userData['mname'], "lname" => $userData['lname'], "role" => $userData['role_id']];

        //         // Fetch all sidebar data

        //         $nhif = $this->nhifModel->first();
        //         if ($nhif['env_status'] == 1) {
        //             $data['env_value'] = $nhif['live'];
        //         } elseif($nhif['env_status'] == 2) {
        //             $data['env_value'] = $nhif['test'];
        //         }
                
        //         // Fetch all sidebar data
        //         $sidebarData = $this->sidebarModel
        //                                     ->select('id, name, type, dropdown, main, link, icon, status')
        //                                     ->where(['status' => 1])
        //                                     ->orderBy('list', 'ASC')
        //                                     ->findAll();

        //         // Split the data into sidebar and sidebarAccess
        //         $data['sidebar'] = array_filter($sidebarData, function($item) use ($data) {
        //             // Check if the 'id' is in the 'permission' array
        //             return $item['main'] == 0 && in_array($item['id'], $data['permission']);
        //         });

        //         $data['sidebarAccess'] = array_map(function($item) {
        //             // Return only the 'id', 'name', and 'status' fields
        //             return [
        //                 'id' => $item['id'],
        //                 'name' => $item['name'],
        //                 'status' => $item['status']
        //             ];
        //         }, $sidebarData);




        //         $data['curDate'] = date('Y-m-d H:i:s');
        //         $data['permissionLevel'] = ['','permission','create','edit','auth','approve','delete'];

        //         $data['deviceType'] = $this->deviceType;
        //         $data['deviceIp'] = $this->deviceIp;
        //         $data['deviceOs'] = $this->deviceOs;

        //     }

        // }

        $profile_picture = $this->userModel->select('profile_picture')
                                ->where("id", $data['userId'])
                                ->first()['profile_picture'];
        if(!empty($profile_picture)){
          $profile_picture = base_url($profile_picture);
        }
        else{
          $profile_picture = base_url("theme/dist/img/avatar5.png");
        }
        $data['profile_picture'] = $profile_picture;


        $request->setGlobal('post', $data);
    }



    // private function getDeviceInfo()
    // {
    //     $deviceType = $this->getDeviceType($_SERVER['HTTP_USER_AGENT']);
    //     $deviceIp = $_SERVER['REMOTE_ADDR'];
    //     $deviceOs = $this->getDeviceOS($_SERVER['HTTP_USER_AGENT']);
        
    //     return [
    //         'deviceType' => $deviceType,
    //         'deviceIp' => $deviceIp,
    //         'deviceOs' => $deviceOs
    //     ];
    // }

    // private function getDeviceType($userAgent)
    // {
    //     if (preg_match('/mobile/i', $userAgent)) {
    //         return 'Mobile';
    //     } elseif (preg_match('/tablet/i', $userAgent)) {
    //         return 'Tablet';
    //     } else {
    //         return 'Desktop';
    //     }
    // }

    // private function getDeviceOS($userAgent)
    // {
    //     if (preg_match('/windows/i', $userAgent)) {
    //         return 'Windows';
    //     } elseif (preg_match('/macintosh|mac os x/i', $userAgent)) {
    //         return 'Mac OS';
    //     } elseif (preg_match('/linux/i', $userAgent)) {
    //         return 'Linux';
    //     } elseif (preg_match('/android/i', $userAgent)) {
    //         return 'Android';
    //     } elseif (preg_match('/iphone/i', $userAgent)) {
    //         return 'iOS';
    //     } else {
    //         return 'Unknown OS';
    //     }
    // }


    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
