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
use App\Models\BrandModel;
use App\Models\CategoryModel;
use App\Models\UnitModel;
use App\Models\TaxModel;
use App\Models\PosModel;
use App\Models\StockModel;
use App\Models\HoldModel;
use App\Models\CountryModel;
use App\Models\StatesModel;
use App\Models\paymenttypesModel;
use App\Models\CustomerModel; 
use App\Models\CompanyModel; 


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


    public static function brandModel(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('brandModel');
        }

        return new BrandModel();
    }


    public static function categoryModel(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('categoryModel');
        }

        return new CategoryModel();
    }

    public static function unitModel(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('unitModel');
        }

        return new UnitModel();
    }

    public static function taxModel(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('taxModel');
        }

        return new TaxModel();
    }


    public static function posModel(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('posModel');
        }

        return new PosModel();
    }


    public static function stockModel(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('stockModel');
        }

        return new StockModel();
    }


    public static function holdModel(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('holdModel');
        }

        return new HoldModel();
    }


    public static function countryModel(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('countryModel');
        }

        return new CountryModel();
    }


    public static function statesModel(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('statesModel');
        }

        return new StatesModel();
    }


    public static function paymenttypesModel(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('paymenttypesModel');
        }

        return new PaymenttypesModel();
    }


    public static function customerModel(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('customerModel');
        }

        return new customerModel();
    }


    public static function companyModel(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('companyModel');
        }

        return new CompanyModel();
    }


}
