<?php namespace App\Policies;

class ModulesAccess
{
    private $token;
    private $module;

    public function __construct($token, $module)
    {
        $this->token = $token;
        $this->module = $module;
    }

    public function getToken()
    {
        return $this->token;
    }
    public function getModule()
    {
        return $this->module;
    }
}