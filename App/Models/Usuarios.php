<?php namespace App\Models;

use App\Core\DatabaseAbstract;

class Usuarios extends DatabaseAbstract
{
    /**
     * @author DamianDev
     * 
     * Con esta clase manipulamos las interacciones con el modelo de los usuarios
     * Establecemos las propiedades iniciales de cada modelo
     */
    
    public $timestamps = false;

    protected $table = 'usuarios';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'nombre', 'correo', 'clave', 'codigo_confirmacion', 'usuario_confirmado', 'maximo_sesiones'
    ];

}