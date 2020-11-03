<?php namespace App\Core;

use App\Core\Validador;
use App\Core\CoreTemplates;

class Genesis
{
    /**
     * @author DamianDev <damian27goa@gmail.com>
     * 
     * Esta funcion inicializa el proceso de validacion y ejecucion de logica de negocios 
     * para cada parte del sistema.
     * 
     * Se crea una instancia del objeto validador que recibe como parametro el objeto que manipula 
     * los request que llegan a la aplicacion
     * 
     * Se valida que no exista un error en el validador
     * 
     * En el caso de que no exista un error vamos a crear un objeto que va a efectuar las acciones necesarias correspondientes a 
     * cada peticion recibida por el sistema
     * 
     * En el caso de que exista un error devolberemos la respuesta del validador con el detalle del error
     * 
     */

    protected $templates;

    public function __construct($templates)
    {
        $this->templates = $templates;
    }

    public function run($request)
    {
       $validador = Validador::getValidador($request);

       switch($validador->getHttpMethod())
       {
            case 'GET':
                $validador->validateTokenUrl($this->templates);
            break;

            case 'POST': 
                dd($_COOKIE);
                $validador->validarOptions();

                if($validador->getStatus() == 200)
                {
                        $validador->MakeOptions();

                        if($validador->getStatus() == 200)
                        {
                            $version = $validador->getVersion();
                            $endpoint = $validador->getEndpoint();

                            $class = "App\Controllers\\".$version."\\".$endpoint;

                            if(class_exists($class))
                            {
                                $method = $validador->getMethod();
                                $newAction = new $class();

                                if(method_exists($newAction, $method))
                                {
                                    die('existe');
                                }
                                else
                                {
                                    $response = [
                                        'error' => 'El metodo solicitado no existe'
                                    ];
                                    $status = 401;
                    
                                    $validador->setContent($response);
                                    $validador->setStatus($status);
                    
                                    $validador->makeResponse()->send();
                                }
                            }
                            else
                            {
                                $response = [
                                    'error' => 'La version o endpoint no existen'
                                ];
                                $validador->setContent($response);
                                $validador->setStatus(401);
                                $validador->makeResponse()->send();
                            }
                        }
                        else
                        {
                            $validador->getResponse()->send();    
                        }
                }
                else
                {
                        $validador->makeResponse()->send();
                }
            break;
       }
    }
}