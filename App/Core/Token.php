<?php namespace App\Core;

class Token
{
    /**
     * @author DamianDev
     * 
     * Clase de transporte de informacion y tokenizacion
     * 
     */
    private $userId;
    private $correo;

    public function __construct()
    {
        $this->userId = "usuario";
        $this->correo = "Damiandev@mail.com";

    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getCorreo()
    {
        return $this->correo;
    }
}