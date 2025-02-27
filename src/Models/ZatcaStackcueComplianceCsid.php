<?php

namespace Sabith\StackcueZat2Laravel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZatcaStackcueComplianceCsid extends Model
{
    use HasFactory;
    
    protected $table = 'zatca_stackcue_compliance_csids'; 
    
    protected $fillable = [
        'cert_name','company_id','user_id','common_name', 'email', 'location', 'company_name', 'vat_number', 
        'is_required_simplified_doc', 'is_required_standard_doc', 
        'device_serial_number1', 'device_serial_number2', 'device_serial_number3',
        'reg_address', 'business_category', 'otp',
        'stackcue_compliance_identifier', 'certificate_issue_date', 'certificate_expiry_date','overall_Status'
    ];

    protected $casts = [
        'data' => 'array',
    ];
}
//STACKCUE_API_END_POINT_BASE_URL =https://sandbox.stackcueprime.com
//STACKCUE_API_ACCESS_TOKEN =10|cz8t9Mk9cI7ncKlfPxycMBQYpeneWocx3oWFrP1Yc7cfec86