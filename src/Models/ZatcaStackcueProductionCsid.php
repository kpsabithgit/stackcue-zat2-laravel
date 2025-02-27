<?php

namespace Sabith\StackcueZat2Laravel\Models;

use Illuminate\Database\Eloquent\Model;

class ZatcaStackcueProductionCsid extends Model
{
    protected $table = 'zatca_stackcue_production_csids'; 

    protected $fillable = [
        'compliance_id', 
        'cer_issue_date', 
        'cer_exp_date',
        'stackcue_production_identifier', 
        'overall_status',

    ];
}
