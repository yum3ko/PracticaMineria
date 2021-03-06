<?php
namespace Prueba\Managers;

class DetallesManager extends BaseManager{

    public function getRules()
    {
        $rules = [
            'numero_maximo' => 'required',
            'historial_id'  => 'required',
            'url'           => '',
            'palabra_clave' => '',
            'coincidencias' => ''
        ];

        return $rules;
    }

    public function prepareData($data)
    {
        return $data;
    }

}
