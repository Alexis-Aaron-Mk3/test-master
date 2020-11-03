<?php 

/**
 * @author DamianDev
 * 
 * En este documento se incluyen las confuguraciones generales de toda a aplicacion
 * 
 * Primero cargamos la libreria para manipular la informacion con la base de datos
 * 
 * Despues cargamos la libreria de Whoops para la inspeccion de errores
 */

 // Arreglo conla configuracion basica de conexion a la base de datos
$configBase =[
    'driver' =>'mysql',
    'host' => 'localhost',
    'database' => 'crm',
    'username' => 'root',
    'password' => 'damian',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
   ];

// Cargamos la libreria de conexiones
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;
$capsule->addConnection($configBase);
$capsule->bootEloquent();

// Carga de la libreria Woops para el debug de errores
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

// Con esta validacion eliminamos los problemas del protocolo CORS
if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
{
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, endpoint, method");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    exit();
}