<?php
namespace Prueba\Managers;

class HistorialManager extends BaseManager{

    public function getRules()
    {
        $rules = [
            'url' => 'required'
        ];

        return $rules;
    }

    public function prepareData($data)
    {
        return $data;
    }

}
