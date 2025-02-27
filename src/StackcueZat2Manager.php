<?php
// src/StackcueZat2Manager.php
namespace Sabith\StackcueZat2Laravel;

class StackcueZat2Manager
{
    protected $saasCompanyIdCallback;
    protected $userIDCallback;

    /**
     * Set the callback for retrieving saas_company_id.
     */
    public function setSaasCompanyIdCallback(callable $callback)
    {
        $this->saasCompanyIdCallback = $callback;
    }

    public function setUserIDCallback(callable $callback)
    {
        $this->userIDCallback = $callback;
    }

    /**
     * Get the saas_company_id.
     */
    public function getSaasCompanyId()
    {
        if ($this->saasCompanyIdCallback) {
            return call_user_func($this->saasCompanyIdCallback);
        }
        return null; // or a default value
    }

    public function getUserID()
    {
        if ($this->userIDCallback) {
            return call_user_func($this->userIDCallback);
        }
        return null; // or a default value
    }

    
}