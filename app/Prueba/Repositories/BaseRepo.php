<?php
namespace Prueba\Repositories;

abstract class BaseRepo {

  protected $model;

  public function __construct()
  {
    $this->model = $this->getModel();
  }

  //metodo getModel
  abstract public function getModel();


  public function find($id)
  {
    return $this->model->find($id);
  }

  public function all()
  {
    return $this->model->all();
  }

    public function paginate($take = 10)
    {
        return $this->model->paginate($take);
    }

    public function simplePaginate($take = 10)
    {
        return $this->model->simplePaginate($take);
    }


}
