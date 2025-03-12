<?php
namespace Sabith\StackcueZat2Laravel\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Einvoicing\ZatcaController;


class ConfigurationController extends Controller{


    public static function getSaasCompanyId(){
        //return app('stackcue-zat2')->getSaasCompanyId(); // managed by parent application. read readme for more info.
        return ZatcaController::companyAnduser()['company_id'];
    }

    public static function getUserID(){

        return ZatcaController::companyAnduser()['user_id'];
        //return app('stackcue-zat2')->getUserID(); // managed by parent application. read readme for more info.
    }

    public static function sellerDetailsforonboarding(){
        return ZatcaController::sellerDetailsforonboarding();

    }
}
