<?php
namespace Prueba\Entities;

class Historial extends \Eloquent {

    protected $table = 'historial';
    protected $fillable = array('url');

    public function detalles(){
        return $this->hasMany('Prueba\Entities\Detalles','id','historial_id');
    }

}
