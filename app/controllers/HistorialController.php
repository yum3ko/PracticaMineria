<?php
use Prueba\Entities\Historial;
use Prueba\Repositories\HistorialRepo;


class HistorialController extends BaseController {

  	protected $historialRepo;


    public function __construct(HistorialRepo $historialRepo)
    {
    	$this->historialRepo = $historialRepo;
	}

	public function index()
	{
		$datos = $this->historialRepo->all();

		return View::make('historial', compact('datos'));
	}
	

}