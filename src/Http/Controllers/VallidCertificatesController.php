<?php
namespace Sabith\StackcueZat2Laravel\Http\Controllers;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Sabith\StackcueZat2Laravel\Models\ZatcaStackcueComplianceCsid;
use Sabith\StackcueZat2Laravel\Models\ZatcaStackcueProductionCsid;


class VallidCertificatesController extends Controller{

    public static function getfirst(){

        $currentDate = Carbon::now()->toDateString(); // Format: 'Y-m-d'

        return ZatcaStackcueComplianceCsid::with('productioncsid')
        ->whereDate('certificate_expiry_date', '>=', $currentDate)
        ->get()->first();
    }

    public static function increaseICVandAddPIH($id,$PIHvalue){
        ZatcaStackcueProductionCsid::where('id', $id)->increment('icv', 1, ['PIHvalue' => $PIHvalue]);    }

    
}
