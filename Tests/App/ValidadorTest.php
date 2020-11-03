<?php

use PHPUnit\Framework\TestCase;
use App\Core\Validador;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse as Response;

class ValidadorTest extends TestCase
{
    
    // Pruebas de validacion de options
    //---------------------------------------------------->
    public function ErrorSinOptions()
    {
        
        $request = Request::create("test.dev", "POST", [], [], [], [], 'test');

        $validador = Validador::getValidador($request);

        $validador->validarOptions();

        $error[] = [
            'message' => 'Error, el campo options es obligatorio'
        ];

        // Validando el contenido del error validando el campo options
        $this->assertEquals($error, $validador->getContent());

        // Validando el status del error
        $this->assertEquals(401, $validador->getStatus());
    }

    public function ErrorOptionDesconocido()
    {
        $request = Request::create("test.dev", "POST", [], [], [], [], 'test');

        $request->headers->set('option', 'registr');

        $validador = Validador::getValidador($request);
        
        $validador->validarOptions();

        $error[] = [
            'message' => 'Error, el campo options es desconocido'
        ];

        // Validando el contenido del error validando el campo options
        $this->assertEquals($error, $validador->getContent());

        // Validando el status del error
        $this->assertEquals(402, $validador->getStatus());

        $response = new Response($error, 402, []);

        $this->assertEquals($response, $validador->getResponse());
    }
    
    
    public function SuccessOptions()
    {
        $request = Request::create("test.dev", "POST", [], [], [], [], 'test');

        $request->headers->set('option', 'registro');

        $validador = Validador::getValidador($request);
        
        $validador->validarOptions();

        

        // Validando el contenido del error validando el campo options
        $this->assertEquals(200, $validador->getStatus());
    }

    // Stack de pruebas de registro
    //---------------------------------------------------->
    public function RegistroSinParametros()
    {
        
        $request = Request::create("test.dev", "POST", [], [], [], [], null);

        $request->headers->set('option', 'registro');

        $validador = Validador::getValidador($request);
        
        $validador->validarOptions();

        $validador->MakeOptions();

        $error[] = [
            'message' => 'Error, el campo options es desconocido'
        ];
        
        $this->assertEquals($error, $validador->getContent());

        // Validando el contenido del error validando el campo options
        $this->assertEquals(401, $validador->getStatus());
    }

    
    public function RegistroParametrosIncorrectos()
    {
        $params = [
            'damian' => 'valor',
            'test' => 'test'
        ];
        $request = Request::create("test.dev", "POST", [], [], [], [], json_encode($params, true));

        $request->headers->set('option', 'registro');

        $validador = Validador::getValidador($request);
        
        $validador->validarOptions();

        $validador->MakeOptions();
        
        $error = [
            ['error' => 'El parametro damian no es reconocido'],
            ['error' => 'El parametro test no es reconocido']
        ];
        
        $this->assertEquals($error, $validador->getContent());

        $this->assertEquals(401, $validador->getStatus());

        $response = new Response($error, 401, []);

        $this->assertEquals($response, $validador->getResponse());
    }

    
    public function RegistroUnParametroSiOtrosEquivocados()
    {
        $params = [
            'nombres' => "Test",
            'test' => 'test'
        ];
        $request = Request::create("test.dev", "POST", [], [], [], [], json_encode($params, true));

        $request->headers->set('option', 'registro');

        $validador = Validador::getValidador($request);
        
        $validador->validarOptions();

        $validador->MakeOptions();

        $error = [
            ['error' => 'El parametro test no es reconocido'],
            ['error' => 'El parametro apellidos es obligatorio'],
            ['error' => 'El parametro correo es obligatorio'],
            ['error' => 'El parametro clave es obligatorio'],
            ['error' => 'El parametro clave_confirmacion es obligatorio'],
        ];
        
        $this->assertEquals($error, $validador->getContent());

        $this->assertEquals(401, $validador->getStatus());

        $response = new Response($error, 401, []);

        $this->assertEquals($response, $validador->getResponse());
    }

    
    public function RegistroSuccessParams()
    {
        $params = [
            'nombres' => 'Damian', 
            'apellidos' => 'Gonzalez', 
            'correo' => 'damian27goa@gmail.com', 
            'clave' => '123', 
            'clave_confirmacion' => '123'
        ];
        $request = Request::create("test.dev", "POST", [], [], [], [], json_encode($params, true));

        $request->headers->set('option', 'registro');

        $validador = Validador::getValidador($request);
        
        $validador->validarOptions();

        $validador->MakeOptions();
        
        $error = [
            'error' => 'Los campos de clave no coinciden'
        ];
        
        $this->assertEquals($error, $validador->getContent());

        $this->assertEquals(401, $validador->getStatus());

        $response = new Response($error, 401, []);

        $this->assertEquals($response, $validador->getResponse());
    }

    
    public function ErrorClaves()
    {
        $params = [
            'nombres' => 'Damian', 
            'apellidos' => 'Gonzalez', 
            'correo' => 'damian27goa@gmail.com', 
            'clave' => '123', 
            'clave_confirmacion' => 'test'
        ];
        $request = Request::create("test.dev", "POST", [], [], [], [], json_encode($params, true));

        $request->headers->set('option', 'registro');

        $validador = Validador::getValidador($request);
        
        $validador->validarOptions();

        $validador->MakeOptions();
        
        $error[] = [
            'error' => 'Los campos de clave no coinciden'
        ];
        
        $this->assertEquals($error, $validador->getContent());

        $this->assertEquals(401, $validador->getStatus());

        $response = new Response($error, 401, []);

        $this->assertEquals($response, $validador->getResponse());
    }

    // Stack de pruebas de verificar codigo
    //--------------------------------------------------------------------->
    /** @test */
    public function ParametrosNoExistentes()
    {
        $params = [
            'correo' => 'Damian', 
            'clave' => 'Gonzalez'
        ];

        $request = Request::create("test.dev", "POST", [], [], [], [], json_encode($params, true));

        $request->headers->set('option', 'login');

        $validador = Validador::getValidador($request);
         
        $validador->validarOptions();

        $validador->MakeOptions();

        var_dump($validador);die();
    }

}