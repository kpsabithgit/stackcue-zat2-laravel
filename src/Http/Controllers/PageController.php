<?php

namespace Sabith\StackcueZat2Laravel\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Sabith\Zatcaphase2\Invoice;
use App\Http\Controllers\Controller;
use Sabith\Zatcaphase2\ComplianceCSID;
use Sabith\Zatcaphase2\ProductionCSID;
use Sabith\StackcueZat2Laravel\Models\ZatcaStackcueComplianceCsid;

class PageController extends Controller
{
    public function standardinvoice()
    {
        return view('stackcue-zat2::standardinvoice');
    }
    public function standarddebitnote()
    {
        return view('stackcue-zat2::standarddebitnote');
    }
    public function standardcreditnote()
    {
        return view('stackcue-zat2::standardcreditnote');
    }
    public function simplifiedinvoice()
    {
        return view('stackcue-zat2::simplifiedinvoice');
    }
    public function simplifiedcreditnote()
    {
        return view('stackcue-zat2::simplifiedcreditnote');
    }
    public function simplifieddebitnote()
    {
        return view('stackcue-zat2::simplifieddebitnote');
    }
    public function productioncsid()
    {
        return view('stackcue-zat2::productioncsid');
    }
    public function compliancecsid()
    {
        return view('stackcue-zat2::compliancecsid');
    }

    public function storeForm(Request $request)
    {
        $isRequiredSimplifiedDoc = filter_var($request->input('isRequiredSimplifiedDoc'), FILTER_VALIDATE_BOOLEAN);
        $isRequiredStandardDoc = filter_var($request->input('isRequiredStandardDoc'), FILTER_VALIDATE_BOOLEAN);

        $compliancecsid = new ComplianceCSID();
        $compliancecsid
            ->email($request->input('email'))
            ->commonName($request->input('commonName'))
            ->location($request->input('location'))
            ->companyName($request->input('companyName'))
            ->vatNumber($request->input('vatNumber'))
            ->isRequiredSimplifiedDoc($isRequiredSimplifiedDoc)
            ->isRequiredStandardDoc($isRequiredStandardDoc)
            ->deviceSerialNumber1($request->input('deviceSerialNumber1'))
            ->deviceSerialNumber2($request->input('deviceSerialNumber2'))
            ->deviceSerialNumber3($request->input('deviceSerialNumber3'))
            ->regAddress($request->input('regAddress'))
            ->businessCategory($request->input('businessCategory'))
            ->otp($request->input('otp'));

        $response = $compliancecsid->sendAPIrequest();


        if (is_string($response)) {
            $response = json_decode($response, true); // Decode the JSON string into an associative array
        }

        // Check if the response is now an array
        if (is_array($response) && isset($response['stackcueHelper'])) {
            $stackcueHelper = $response['stackcueHelper'];

            if (isset($stackcueHelper['overallStatus']) && $stackcueHelper['overallStatus'] == 1) {


                $certificateIssueDate = Carbon::createFromFormat('d-m-Y H:i:s', $stackcueHelper['CerIssueDate'])->format('Y-m-d H:i:s');
                $certificateExpiryDate = Carbon::createFromFormat('d-m-Y H:i:s', $stackcueHelper['CerExpDate'])->format('Y-m-d H:i:s');
                $satus = $stackcueHelper['overallStatus'];
                $data = [
                    'cert_name' => Str::uuid(),
                    'company_id' => ConfigurationController::getSaasCompanyId(),
                    'user_id' => ConfigurationController::getUserID(),
                    'common_name' => $request->input('commonName'),
                    'email' => $request->input('email'),
                    'location' => $request->input('location'),
                    'company_name' => $request->input('companyName'),
                    'vat_number' => $request->input('vatNumber'),
                    'is_required_simplified_doc' => $isRequiredSimplifiedDoc,
                    'is_required_standard_doc' => $isRequiredStandardDoc,
                    'device_serial_number1' => $request->input('deviceSerialNumber1'),
                    'device_serial_number2' => $request->input('deviceSerialNumber2'),
                    'device_serial_number3' => $request->input('deviceSerialNumber3'),
                    'reg_address' => $request->input('regAddress'),
                    'business_category' => $request->input('businessCategory'),
                    'otp' => $request->input('otp'),
                    'stackcue_compliance_identifier' => $stackcueHelper['stackcueComplianceIdentifier'],
                    'overall_Status' => $stackcueHelper['overallStatus'],
                    'certificate_issue_date' =>  $certificateIssueDate,
                    'certificate_expiry_date' => $certificateExpiryDate,

                ];
           

                ZatcaStackcueComplianceCsid::create($data);

                return response()->json([
                    'success' => true,
                    'message' => 'Compliance Certificate Generated.',
                    'data' => $data,
                ], 200);
            }


            return response()->json([
                'success' => false,
                'message' => 'API request failed.',
                'errors' => 'Overall status indicates failure.',
            ], 500);
        }
    }



    public function index()
    {
        //dd(app('stackcue-zat2')->getSaasCompanyId());
        $complianceData = ZatcaStackcueComplianceCsid::all();
        return view('stackcue-zat2::zatca_stackcue_compliance_csid_index', compact('complianceData'));
    }






    public function destroy($id)
    {

        $compliance = ZatcaStackcueComplianceCsid::find($id);

        if ($compliance) {

            $compliance->delete();


            return redirect()->route('compliance-csids.index')->with('success', 'Record deleted successfully!');
        }


        return response()->json(['status' => 'error', 'message' => 'Record not found'], 404);
    }




    public static function execute($documenttype)
    {

        $invoice = new Invoice();

        $invoice->stackcue()
            ->documentType($documenttype)
            ->stackcueComplianceIdentifier('3fb0acc9-27da-458a-a9a1-cc9583d351ad')
            //->stackcueProductionIdentifier('0c2f3b77-e5a8-407e-81f4-63cc03e8db1f')
            ->qrX(55)
            ->qrY(120)
            ->qrSize(150);


        // Invoice Section
        $invoice->invoice()
            ->id('SME00061')
            ->issueDate('2022-09-07')
            ->issueTime('12:21:28')
            ->invoiceCounterValue(101)
            ->actualDeliveryDate('2022-09-07')
            ->paymentMeansCode(10)
            ->PIHvalue('NWZlY2ViNjZmZmM4NmYzOGQ5NTI3ODZjNmQ2OTZjNzljMmRiYzIzOWRkNGU5MWI0NjcyOWQ3M2EyN2ZiNTdlOQ==')
            ->referanceInvoiceID('SMI00023')
            ->reasonForCreditOrDebitNote('Item Returned');

        // Seller Section
        $invoice->seller()
            ->partyIdentificationId('454634645645654')
            ->partyIdentificationIdType('CRN')
            ->streetName('Riyadh')
            ->buildingNumber('2322')
            //->plotIdentification('2223')
            //->citySubdivisionName('Riyad')
            ->cityName('Riyadh')
            ->postalZone('23333')
            ->companyID('399999999900003')
            ->registrationName('Acme Widgets LTD');

        // Customer Section
        $invoice->customer()
            //->partyIdentificationId('2345')
            //->partyIdentificationIdType('NAT')
            ->streetName('Riyadh')
            ->buildingNumber('1111')
            //->plotIdentification('2223')
            //->citySubdivisionName('Riyadh')
            ->cityName('Dammam')
            ->postalZone('12222')
            ->country('SA')
            ->companyID('399999999400003')
            ->registrationName('Acme Widgets LTD 2');

        // Document Allowances
        $invoice->addDocumentAllowance()
            ->allowanceReason('Free Text for allowance')
            ->allowanceAmount(1.00)
            ->allowanceTaxCategoryID('S')
            ->allowanceTaxPercentage(15);

        // Document Charges
        $invoice->addDocumentCharge()
            ->chargeReason('Advertising')
            ->chargeAmount(10.0)
            ->chargeTaxCategoryID('S')
            ->chargeTaxPercentage(15);

        // PrePaid Documents
        $invoice->addPrePaidDocument()
            ->prePaymentDocumentId('123')
            ->prePaymentDocumentIssueDate('2021-07-31')
            ->prePaymentDocumentIssueTime('12:28:17')
            ->prePaymentCategoryAmount('S', 2.00)
            ->prePaymentCategoryAmount('E', 0.00)
            ->prePaymentCategoryAmount('Z', 0.00)
            ->prePaymentCategoryAmount('O', 0.00);

        $invoice->addPrePaidDocument()
            ->prePaymentDocumentId('124')
            ->prePaymentDocumentIssueDate('2021-07-31')
            ->prePaymentDocumentIssueTime('12:28:17')
            ->prePaymentCategoryAmount('S', 1.00)
            ->prePaymentCategoryAmount('E', 0.00)
            ->prePaymentCategoryAmount('Z', 0.00)
            ->prePaymentCategoryAmount('O', 0.00);

        // Line Item
        $invoice->addLineItem()
            ->lineID(1)
            ->invoicedQuantity(1)
            ->invoicedQuantityUnit('Pce')
            ->baseQuantity(1000)
            ->currency('SAR')
            // ->currency2('SAR')
            ->name('Juice')
            ->categoriesCode('S')
            ->vatPercentage(15)
            ->grossAmount(10)
            ->priceAllowanceReason('FREETEXT')
            ->priceAllowanceAmount(1)
            ->lineAllowanceMethod('percentage') //percentage or direct
            ->itemlineAllowance_UNE_Reason('Discount')
            ->lineAllowanceAmount(1)
            ->lineAllowancePercentage(10)
            ->baseAmountForLineAllowance(11)
            ->lineChargeMethod('percentage') //percentage or direct
            ->itemlineCharge_UNE_Reason('Advertising')
            ->lineChargeAmount(1.00)
            ->lineChargePercentage(10)
            ->baseAmountForLineCharge(11);


        return $invoice->APIcomplianceInvoiceCheck();
    }
}
