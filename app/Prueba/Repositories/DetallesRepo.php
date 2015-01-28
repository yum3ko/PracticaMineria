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

}
