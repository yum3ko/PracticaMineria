<?php
namespace Prueba\Entities;

class Detalles extends \Eloquent {

    protected $table = 'detalles';
    protected $fillable = array('url', 'historial_id', 'palabra_clave', 'coincidencias');

    public function historial() {
        return $this->belongsTo('Prueba\Entities\Historial');
    }

}
