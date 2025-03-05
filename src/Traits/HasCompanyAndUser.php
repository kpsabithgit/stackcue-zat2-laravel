<?php

namespace Sabith\StackcueZat2Laravel\Traits;

use Illuminate\Database\Eloquent\Builder;
use Sabith\StackcueZat2Laravel\Http\Controllers\ConfigurationController;

trait HasCompanyAndUser
{
    /**
     * Boot the trait.
     *
     * @return void
     */
    protected static function bootHasCompanyAndUser()
    {
        static::addGlobalScope('company_and_user', function (Builder $builder) {
            // Get the company_id and user_id from the service container
            $companyId = ConfigurationController::getSaasCompanyId();
            $userId = ConfigurationController::getUserID();

            // Apply the constraints
            $builder->where('company_id', $companyId)
                    ->where('user_id', $userId);
        });
    }
}

