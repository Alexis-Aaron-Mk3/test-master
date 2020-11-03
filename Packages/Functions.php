<?php 

/**
 * @author DamianDev
 * 
 * Este documento contiene funciones que se usan de forma global en el sistema
 * 
 */

function dd($param)
{
    echo "<pre style='background-color: black; color: white;'>";
    die(var_dump($param));
}

function createToken($tokenName, $body)
{
    $tokenPath = '../Tokens/'.$tokenName.".json";

    $file = fopen($tokenPath, "w");
    fwrite($file, $body);
    fclose($file);
}

function getTokenByKey($tokenName)
{
    $tokenPath = '../Tokens/'.$tokenName.'.json';
    
    if(file_exists($tokenPath))
    {
        return file_get_contents($tokenPath);
    }
    else 
    {
        return null;
    }
}

function getModuleExists($pathRequest)
{
    $path = '../public/modules'.$pathRequest.'/index.php';

    if(file_exists($path))
    {
        return true;
    }
    else 
    {
        return false;
    }
}