<?php
namespace Prueba\Repositories;

use Prueba\Entities\Detalles;

class DetallesRepo extends BaseRepo{

    public function getModel()
    {
        return new Detalles;
    }

    public function newDetalles()
    {
        $detalles       = new Detalles();
        return $detalles;
    }

    public function getList()
    {
        return Detalles::lists('url', 'id');
    }

    public function getDetallesByHistorial($historial_id)
    {
        return Detalles::where('historial_id', '=', $historial_id)->get();
    }

}
