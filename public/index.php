<?php session_start();
echo 'hola mundo';
die;
/**
 * @author DamianDev
 * 
 * Aquí es en donde cargamos las peticiones hacia los endpoints para interactuar con el backend
 * 
 * 1.- Incluimos nuestro documento para cargar automaticamente las clases que sean necesarias
 * 2.- Declaramos nuestro objeto percutor del ciclo de vida del software
 * 3.- Disparamos el metodo run()
 * 
 * 
 */

require_once "../vendor/autoload.php";

require_once "../Packages/Functions.php";

require_once "../Packages/Charger.php";

use Symfony\Component\HttpFoundation\Request;

$templates = new League\Plates\Engine('modules');

$genesis = new App\Core\Genesis($templates);

$genesis->run(Request::createFromGlobals());