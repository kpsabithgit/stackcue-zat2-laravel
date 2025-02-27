<?php
namespace Sabith\StackcueZat2Laravel\Http\Controllers;

use App\Http\Controllers\Controller;


class ConfigurationController extends Controller{

    public static function getSaasCompanyId(){

        return app('stackcue-zat2')->getSaasCompanyId(); // managed by parent application. read readme for more info.
    }

    public static function getUserID(){

        return app('stackcue-zat2')->getUserID(); // managed by parent application. read readme for more info.
    }
}
