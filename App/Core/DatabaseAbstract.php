<?php namespace App\Core;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Expression as raw;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model;

abstract class DatabaseAbstract extends Model
{
    /**
     * @author DamianDev
     * 
     * Esta es una clase abstracta que contiene toda la contiene todo el codigo necesario
     * para la implementacion de la capa de interaccion con las bases de datos de una forma segura
     * Se utiliza el patron de diseño repositorios para dar un nivel de seguridad mas extendido y robusto
     * 
     * 
     * Los modelos que interactuen con las bases de datos deben extender de esta clase
     * 
     */
    
}