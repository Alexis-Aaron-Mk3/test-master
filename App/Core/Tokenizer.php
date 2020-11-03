<?php namespace App\Core;

use App\Core\Token;

class Tokenizer
{
    /**
     * @author DamianDev
     * 
     * Esta clase es la encargada de procesar los tokens dinamicos del sistema de autenticacion de usuarios
     * 
     * Es responsable de: 
     * 
     * 1.- Crear
     * 2.- Manipular 
     * 3.- Modificar
     * 4.- Almacenar 
     * 5.- Eliminar
     * 6.- Verificar
     * 
     * Todos los tokens de acceso son mutables 
     */

    private $tokenKey;
    private $userId;
    private $correo;
    private $token;

    public $activeSessions;

    public function __construct($userId, $correo)
    {
        $this->tokenKey = hash('sha256', $userId."@".$correo); 
        $this->userId = $userId;
        $this->correo = $correo;
        $this->token = getTokenByKey($this->tokenKey);
        
        $this->activeSessions = (!is_null($this->token)) ? count(json_decode($this->token, true)): 0;
    }

    public function createToken($sessionId)
    {
        $firstHash = $this->userId."@".$this->correo."_".rand(5,10);

        $tokenBody = [
            'tokenId' => $sessionId,
            'tokenKey' => $this->tokenKey,
            'userId' => $this->userId,
            'correo' => $this->correo,
            'lastHash' => hash('sha256', $firstHash)
        ];

        $principalBody[$sessionId] = $tokenBody;
        
        $prepareToken = json_encode($principalBody, true);

        createToken($this->tokenKey, $prepareToken);
        
        return base64_encode(json_encode($tokenBody, true));
    }

    public function addToken($sessionId)
    {
        $tokenContent = getTokenByKey($this->tokenKey);

        $principalBody = json_decode($tokenContent, true);

        $firstHash = $this->userId."@".$this->correo."_".rand(5,10);

        $tokenBody = [
            'tokenId' => $sessionId,
            'tokenKey' => $this->tokenKey,
            'userId' => $this->userId,
            'correo' => $this->correo,
            'lastHash' => hash('sha256', $firstHash)
        ];
        $principalBody[$sessionId] = $tokenBody;
        
        $prepareToken = json_encode($principalBody, true);

        createToken($this->tokenKey, $prepareToken);

        return base64_encode(json_encode($tokenBody, true));
    }

    public static function modifyToken($tokenKey, $lastHash, $tokenId, $userId)
    {
        $tokenContent = getTokenByKey($tokenKey);

        $tokenBody = [
            'tokenId' => $tokenId,
            'tokenKey' => $tokenKey,
            'userId' => $userId,
            'lastHash' => str_shuffle(hash('sha256', $lastHash)),
        ];
        $tokenContent[$tokenId] = json_encode($tokenBody, true);

        createToken($tokenKey, $tokenContent);

        return base64_encode(json_encode($tokenBody, true));
    }

    public static function getLastHash($tokenKey, $tokenId)
    {
        $tokenContent = json_decode(getTokenByKey($tokenKey), true);

        return $tokenContent[$tokenId]['lastHash'];
    }
}