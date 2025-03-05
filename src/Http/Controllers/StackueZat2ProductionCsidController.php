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
use Sabith\StackcueZat2Laravel\Models\ZatcaStackcueProductionCsid;

class StackueZat2ProductionCsidController extends Controller
{
    public function sampleComplianceCheck($id)
    {

        $complianceData = ZatcaStackcueComplianceCsid::find($id);

        if (!$complianceData) {
            return response()->json(['success' => false, 'message' => 'Compliance data not found.'], 404);
        }

        $checkCompliance = function ($documentTypes, $id) {
            $results = [];

            foreach ($documentTypes as $docType) {

                $response = $this->execute($docType, $id);
                $decodedResponse = json_decode($response, true);




                // Check if errorMessages exists and is not empty
                if (!empty($decodedResponse['errorMessages'])) {
                    // Access the first error message
                    $errorMessage = $decodedResponse['errorMessages'][0]['message'];
                    $err_message =  "Error Message: " . $errorMessage;
                } else {
                    $err_message = '';
                }


                if (!isset($decodedResponse['stackcueHelper']['overallStatus']) || $decodedResponse['stackcueHelper']['overallStatus'] != 1) {
                    return [
                        'success' => false,
                        'message' => "{$docType} compliance check failed. " . $err_message,
                        'data' => $decodedResponse,
                    ];
                }

                $results[$docType] = $decodedResponse;
            }

            return [
                'success' => true,
                'data' => $results
            ];
        };

        $responseData = [];


        $simplifiedDocuments = ['SimplifiedInvoice', 'SimplifiedCreditNote', 'SimplifiedDebitNote'];
        $standardDocuments = ['StandardInvoice', 'StandardCreditNote', 'StandardDebitNote'];


        if ($complianceData->is_required_simplified_doc) {
            $simplifiedResult = $checkCompliance($simplifiedDocuments, $id);

            if (!$simplifiedResult['success']) {
                return response()->json($simplifiedResult, 500);
            }

            $responseData['simplified'] = $simplifiedResult['data'];
            $complianceData->is_required_simplified_doc = 1;
        }


        if ($complianceData->is_required_standard_doc) {
            $standardResult = $checkCompliance($standardDocuments, $id);

            if (!$standardResult['success']) {
                return response()->json($standardResult, 500);
            }

            $responseData['standard'] = $standardResult['data'];
            $complianceData->is_required_standard_doc = 1;
        }


        $complianceData->save();



        //generating production csid
        $stackcueComplianceIdentifier = ZatcaStackcueComplianceCsid::where('id', $id)->first()->stackcue_compliance_identifier; //'74e88cd4-fc4a-46f9-afee-b2c4cb4d034a';
        $productioncsid = ProductionCSID::sendAPIrequest($stackcueComplianceIdentifier);
        $stackcueHelper = json_decode($productioncsid, true)['stackcueHelper'];

        $cerIssueDateFormatted = Carbon::createFromFormat('d-m-Y H:i:s', $stackcueHelper['CerIssueDate'])->format('Y-m-d H:i:s');
        $cerExpDateFormatted = Carbon::createFromFormat('d-m-Y H:i:s', $stackcueHelper['CerExpDate'])->format('Y-m-d H:i:s');


        ZatcaStackcueProductionCsid::create([
            'compliance_id' => $id,
            'cer_issue_date' => $cerIssueDateFormatted,
            'cer_exp_date' => $cerExpDateFormatted,
            'stackcue_production_identifier' => $stackcueHelper['stackcueProductionIdentifier'],
            'overall_status' => $stackcueHelper['overallStatus'],
        ]);
        return response()->json([
            'success' => true,
            'message' => 'sucess.',
            //'data' => $responseData,
        ], 200);
    }


    public static function execute($documenttype, $id)
    {

        $stackcueComplianceIdentifier = ZatcaStackcueComplianceCsid::where('id', $id)->first()->stackcue_compliance_identifier; //'74e88cd4-fc4a-46f9-afee-b2c4cb4d034a';

        $invoice = new Invoice();

        $invoice->stackcue()
            ->documentType($documenttype)
            ->stackcueComplianceIdentifier($stackcueComplianceIdentifier);
        //->stackcueProductionIdentifier($stackcueProductionIdentifier);



        // Invoice Section
        $invoice->invoice()
            ->id('SME00061')
            ->issueDate(now()->format('Y-m-d'))
            ->issueTime(now()->format('H:i:s'))
            ->invoiceCounterValue(1)
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
            ->plotIdentification('2223')
            ->citySubdivisionName('Riyad')
            ->cityName('Riyadh')
            ->postalZone('23333')
            ->companyID('399999999900003')
            ->registrationName('Acme Widgets LTD');

        // Customer Section
        $invoice->customer()
            ->partyIdentificationId('2345')
            ->partyIdentificationIdType('NAT')
            ->streetName('Riyadh')
            ->buildingNumber('1111')
            ->plotIdentification('2223')
            ->citySubdivisionName('Riyadh')
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
            ->currency2('SAR')
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
