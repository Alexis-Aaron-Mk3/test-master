<?php namespace App\Core;

use App\Core\Tokenizer;
use App\Models\Usuarios;

use Symfony\Component\HttpFoundation\JsonResponse as Response;
use Symfony\Component\HttpFoundation\Response as ResponseHtml;
use Symfony\Component\HttpFoundation\Cookie;

class Validador
{

    /**
     * @author DamianDev <damian27goa@gmail.com>
     * 
     * Esta clase es responsable de validar y filtrar la peticion recibida por el cliente, 
     * tambien es responsable de autorizar los accesos a los diferentes componentes del sistema
     * 
     * El patron de diseño para esta clase es Singleton ya que solo tiene una unica responsabilidad en todo el codigo 
     * y es usada en diferentes secciones del mismo
     */
    public static $instance;

    private $request;
    private $status = 200;
    private $options = [
        'registro', 'verificar', 'login', 'recursiva', 'logout'
    ];
    private $option;
    private $registerParams = [
        'nombres' => true, 
        'apellidos' => true, 
        'correo' => true, 
        'clave' => true, 
        'clave_confirmacion' => true
    ];
    private $verificarParams = [
        'correo' => true, 
        'codigo' => true,
    ];

    private $loguinParams = [
        'correo' => true, 
        'clave' => true,
    ];

    public $error = false;

    private $content = [];
    private $params;

    private $headers = [];
    private $tokenId;
    private $tokenKey;
    private $lastHash;
    private $HttpMethod;

    private $endpoint = null;
    private $method = null;
    private $version = null;
    private $userId;

    private $response;

    private function __construct($request)
    {
        $this->request = $request;
        $this->HttpMethod = $request->server->get('REQUEST_METHOD');
        $this->params = json_decode($this->request->getContent(), true);
    }

    public static function getValidador($request)
    {
        if(!self::$instance)
        {
            return self::$instance = new self($request);
        }
        return self::$instance;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getEndpoint()
    {
        return $this->endpoint;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function makeResponse()
    {
        return new Response($this->content, $this->status, $this->headers);
    }

    public function getHtmlResponse($template)
    {
        return new ResponseHtml($template, 200, $this->headers);
    }

    public function getContent()
    {
        return $this->content;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getTokenId()
    {
        return $this->tokenId;
    }
    public function getTokenKey()
    {
        return $this->tokenKey;
    }
    public function getLastHash()
    {
        return $this->lastHash;
    }

    public function getHttpMethod()
    {
        return $this->HttpMethod;
    }
    public function setContent($content)
    {
        $this->content[] = $content;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function validarOptions()
    {
        $option = $this->request->headers->get("option");

        if(is_null($option))
        {
            $this->content[] = [
                'message' => 'Error, el campo options es obligatorio'
            ];
            $this->status = 401;
        }
        else
        {
            if(!in_array($option, $this->options))
            {
                $this->content[] = [
                    'message' => 'Error, el campo options es desconocido'
                ];
                $this->status = 402;
            }
            else
            {
                $this->option = $option;
                $this->status = 200;
            }
        }
    }

    public function MakeOptions()
    {
        $function = $this->option;

        $this->$function();
    }

    public function validateTokenUrl($templates)
    {
        if($this->request->getPathInfo() != '/')
        {
            if(is_null($this->request->query->get('token')))
            {
                $response = $templates->render('errors/404');

                $this->getHtmlResponse($response)->send();
            }
            else
            {
                $prepareToken = json_decode(base64_decode($this->request->query->get('token')), true);

                if(is_null($prepareToken))
                {
                    $response = $templates->render('errors/404');

                    $this->getHtmlResponse($response)->send();
                }
                else
                {
                    if($this->request->getPathInfo() == '/errors')
                    {
                        $response = $templates->render('errors/404');

                        $this->getHtmlResponse($response)->send();
                    }
                    else
                    {
                        if(getModuleExists($this->request->getPathInfo()))
                        {
                            
                            if(true)
                            {
                                $response = $templates->render($this->request->getPathInfo()."/index", [
                                    'token' => $this->request->query->get('token')
                                    ]);
            
                                $this->getHtmlResponse($response)->send();
                            }
                            else
                            {
                                $response = $templates->render('errors/404');

                                $this->getHtmlResponse($response)->send(); 
                            }
                        }
                        else
                        {
                            $response = $templates->render('errors/404');

                            $this->getHtmlResponse($response)->send();
                        }
                    }
                }
            }
        }
        else
        {
            $response = $templates->render('agenda/index');

            $this->getHtmlResponse($response)->send();
        }
    }

    private function recursivaUrl()
    {

    }

    private function login()
    {
        $params = json_decode($this->request->getContent(), true);

        if(is_null($params))
        {
            $this->content[] = [
                'message' => 'Error, el campo options es desconocido'
            ];
            $this->status = 401;
        }
        else
        {
            foreach($params as $param => $key)
            {
                if(!array_key_exists($param, $this->loguinParams))
                {
                    $this->content[] = [
                        'error' => 'El parametro '.$param.' no es reconocido'
                    ];
                }
                else
                {
                    if(is_null($key))
                    {
                        $this->content[] = [
                            'error' => 'El parametro '.$param.' tiene un valor null'
                        ];
                    }
                    if($key === "" or $key === '')
                    {
                        $this->content[] = [
                            'error' => 'El parametro '.$param.' esta vacío'
                        ];
                    }
                    if(gettype($key) == 'boolean')
                    {
                        $this->content[] = [
                            'error' => 'El parametro '.$param.' no es un tipo valido'
                        ];
                    }
                    unset($this->loguinParams[$param]);
                }
            }
            if(count($this->loguinParams)>=1)
            {
                foreach($this->loguinParams as $param => $key)
                {
                    $this->content[] = [
                        'error' => 'El parametro ' . $param .' es obligatorio'
                    ];
                }
            }
            if(count($this->content)>=1)
            {
                $this->status = 401;
            }
            else
            {
                $usuario = Usuarios::where('correo', $params['correo'])->first();

                if(is_null($usuario))
                {
                    $this->content[] = [
                        'message' => 'Las credenciales no coinciden'
                    ];
                    $this->status = 401;
                }
                else
                {
                    if($usuario->usuario_confirmado == 0)
                    {
                        $this->content[] = [
                            'message' => 'El usuario no esta verificado'
                        ];
                        $this->status = 401;
                    }
                    else
                    {
                        if($usuario->clave != hash('sha256', $params['clave']))
                        {
                            $this->content[] = [
                                'message' => 'Las credenciales no coinciden'
                            ];
                            $this->status = 401;
                        }
                        else
                        {
                            $tokenizer = new Tokenizer($usuario->id, $usuario->correo);
    
                            if($tokenizer->activeSessions >= $usuario->maximo_sesiones)
                            {   
                                $this->content[] = [
                                    'message' => 'No es posible iniciar una nueva sesion mas, comunicate con el administrador'
                                ];
                                $this->status = 401;
                            }
                            else
                            {
                                if($tokenizer->activeSessions == 0)
                                {
                                    $token = $tokenizer->createToken(1);
    
                                    $this->headers['token'] = $token;
    
                                    $this->content[] = [
                                        'message' => 'Bienvenido'
                                    ];
                                    $this->status = 201;

                                    $this->response = new Response($this->content, $this->status, $this->headers);
                                    $this->response->headers->setCookie(Cookie::create('user')
                                                            ->withValue($token));
                                }
                                else
                                {
                                    $sessionId = $tokenizer->activeSessions + 1;
    
                                    $token = $tokenizer->addToken($sessionId);
    
                                    $this->headers['token'] = $token;
    
                                    $this->content[] = [
                                        'message' => 'Bienvenido'
                                    ];
                                    $this->status = 201;
                                    
                                    $this->response = new Response($this->content, $this->status, $this->headers);
                                    $this->response->headers->setCookie(Cookie::create('user')
                                                            ->withValue($token));
                                }
                            }
                        }
                    }   
                }
            }
        }
    }

    private function logout()
    {

    }

    private function registro()
    {
        $params = json_decode($this->request->getContent(), true);
        
        if(is_null($params))
        {
            $this->content[] = [
                'message' => 'Error, el campo options es desconocido'
            ];
            $this->status = 401;
        }
        else
        {
            foreach($params as $param => $key)
            {
                if(!array_key_exists($param, $this->registerParams))
                {
                    $this->content[] = [
                        'error' => 'El parametro '.$param.' no es reconocido'
                    ];
                }
                else
                {
                    if(is_null($key))
                    {
                        $this->content[] = [
                            'error' => 'El parametro '.$param.' tiene un valor null'
                        ];
                    }
                    if($key === "" or $key === '')
                    {
                        $this->content[] = [
                            'error' => 'El parametro '.$param.' esta vacío'
                        ];
                    }
                    if(gettype($key) == 'boolean')
                    {
                        $this->content[] = [
                            'error' => 'El parametro '.$param.' no es un tipo valido'
                        ];
                    }
                    unset($this->registerParams[$param]);
                }
            }
            if(count($this->registerParams)>=1)
            {
                foreach($this->registerParams as $param => $key)
                {
                    $this->content[] = [
                        'error' => 'El parametro ' . $param .' es obligatorio'
                    ];
                }
            }
            if(count($this->content)>=1)
            {
                $this->status = 401;
            }
            else
            {
                 if($params['clave'] != $params['clave_confirmacion'])
                 {
                    $this->content[] = [
                        'error' => 'Los campos de clave no coinciden'
                    ];
                    $this->status = 401;
                 }
                 else
                 {
                    $usuarioExistente = Usuarios::where('correo', $params['correo'])->first();

                    if(is_null($usuarioExistente))
                    {
                        $usuario = Usuarios::create([
                            'nombre' => $params['nombres'],
                            'correo' => $params['correo'],
                            'clave' => hash('sha256', $params['clave']),
                            'codigo_confirmacion' => hash('sha256', rand(5, 15)."_".$params['nombres']),
                            'usuario_confirmado' => 0,
                            'maximo_sesiones' => 5
                        ]);

                        $this->content[] = [
                            'key' => 'success',
                            'message' => 'El usuario fue creado correctamente, un codigo de confirmacion sera enviado a su correo',
                            'data' => [
                                'nombre' => $usuario->nombre,
                                'correo' => $usuario->correo
                            ]
                        ];
                        $this->status = 201;
                    }
                    else
                    {
                        $this->content[] = [
                            'message' => 'El usuario ya esta registrado'
                        ];
                        $this->status = 401;
                    }
                 }
            }
        }
    }

    private function recursiva()
    {
        $token = $this->request->headers->get('token');

        $prepareToken = json_decode(base64_decode($token), true);

        if(is_null($prepareToken))
        {
            $this->content[] = [
                'error' => 'El token recibido no es valido'
            ];
            $this->status = 401;
            $this->headers['token'] = $token;
        }
        else
        {
            $this->endpoint = $this->request->headers->get('endpoint');
            $this->method = $this->request->headers->get('method');
            $this->version = $this->request->headers->get('version');

            if(is_null($this->endpoint) or $this->endpoint == '' or $this->endpoint == "" or
                is_null($this->method) or $this->method == '' or $this->method == "" or
                is_null($this->version) or $this->version == '' or $this->version == ""
            )
            {
                if(is_null($this->endpoint) or $this->endpoint == '' or $this->endpoint == "")
                {
                    $this->content[] = [
                        'error' => 'Error el header endpoint es obligatorio'
                    ];
                }
                if(is_null($this->method) or $this->method == '' or $this->method == "")
                {
                    $this->content[] = [
                        'error' => 'Error el header method es obligatorio'
                    ];
                }
                if(is_null($this->version) or $this->version == '' or $this->version == "")
                {
                    $this->content[] = [
                        'error' => 'Error el header version es obligatorio'
                    ];
                }

                $this->status = 401;
            }
            else
            {
                $lastHash = Tokenizer::getLastHash($prepareToken['tokenKey'], $prepareToken['tokenId']);

                if(is_null($lastHash))
                {
                    $this->content[] = [
                        'error' => 'El token recibido no es valido'
                    ];
                    $this->status = 401;
                    $this->headers['token'] = $token;
                }
                else
                {
                    if($lastHash == $prepareToken['lastHash'])
                    {
                        $this->status = 200;
                        $this->headers['token'] = $token;
                        $this->tokenId = $prepareToken['tokenId'];
                        $this->tokenKey = $prepareToken['tokenKey'];
                        $this->lastHash = $lastHash;
                        $this->userId = $prepareToken['userId'];
                    }
                    else
                    {
                        $this->content[] = [
                            'error' => 'El token recibido no es valido'
                        ];
                        $this->status = 401;
                    }
                }
            }
        }        
    }

    private function verificar()
    {
        $params = json_decode($this->request->getContent(), true);
          
        if(is_null($params))
        {
            $this->content[] = [
                'message' => 'Error, el campo options es desconocido'
            ];
            $this->status = 401;
        }
        else
        {
            foreach($params as $param => $key)
            {
                if(!array_key_exists($param, $this->verificarParams))
                {
                    $this->content[] = [
                        'error' => 'El parametro '.$param.' no es reconocido'
                    ];
                }
                else
                {
                    if(is_null($key))
                    {
                        $this->content[] = [
                            'error' => 'El parametro '.$param.' tiene un valor null'
                        ];
                    }
                    if($key === "" or $key === '')
                    {
                        $this->content[] = [
                            'error' => 'El parametro '.$param.' esta vacío'
                        ];
                    }
                    if(gettype($key) == 'boolean')
                    {
                        $this->content[] = [
                            'error' => 'El parametro '.$param.' no es un tipo valido'
                        ];
                    }
                    unset($this->verificarParams[$param]);
                }
            }
            if(count($this->verificarParams)>=1)
            {
                foreach($this->verificarParams as $param => $key)
                {
                    $this->content[] = [
                        'error' => 'El parametro ' . $param .' es obligatorio'
                    ];
                }
            }
            if(count($this->content)>=1)
            {
                $this->status = 401;
            }
            else
            {
                $usuario = Usuarios::where('correo', $params['correo'])->first();
                
                if(!is_null($usuario))
                {
                    if($usuario->codigo_confirmacion != $params['codigo'])
                    {
                        $this->content[] = [
                            'message' => 'El codigo de confirmacion es incorrecto'
                        ];
                        $this->status = 401;
                    }
                    else
                    {
                        $usuario->usuario_confirmado = 1;
                        $usuario->save();

                        $this->content[] = [
                            'message' => 'El usuario ha sido verificado correctamente, ya es posible iniciar sesion'
                        ];
                        $this->status = 201;
                    }
                }
                else
                {
                    $this->content[] = [
                        'message' => 'El usuario no esta registrado'
                    ];
                    $this->status = 401;
                }
            }
        }
    }
}