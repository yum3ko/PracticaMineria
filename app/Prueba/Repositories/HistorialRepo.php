<?php
namespace Prueba\Repositories;

use Prueba\Entities\Historial;

class HistorialRepo extends BaseRepo{

    public function getModel()
    {
        return new Historial;
    }

    public function newHistorial()
    {
        $historial       = new Historial();
        return $historial;
    }

    public function getList()
    {
        return Historial::lists('url', 'id');
    }


}
