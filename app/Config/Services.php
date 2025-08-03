<?php

namespace Config;

use CodeIgniter\Config\BaseService;
use App\Libraries\MyCoredata;
use App\Models\SitesettingsModel;
use App\Models\UserModel;
use App\Models\DashboardModel;
use App\Models\ItemsModel;
use App\Models\PurchaseModel;
use App\Models\SalesModel;


/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    /*
     * public static function example($getShared = true)
     * {
     *     if ($getShared) {
     *         return static::getSharedInstance('example');
     *     }
     *
     *     return new \CodeIgniter\Example();
     * }
     */


    public static function coredata(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('coredata');
        }

        return new MyCoredata();
    }

    public static function sitesettingsModel(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('sitesettingsModel');
        }

        return new SitesettingsModel();
    }


    public static function userModel(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('userModel');
        }

        return new UserModel();
    }

    public static function dashboardModel(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('dashboardModel');
        }

        return new DashboardModel();
    }


    public static function itemsModel(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('itemsModel');
        }

        return new ItemsModel();
    }


    public static function purchaseModel(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('purchaseModel');
        }

        return new PurchaseModel();
    }


    public static function salesModel(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('salesModel');
        }

        return new SalesModel();
    }


}
