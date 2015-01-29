<?php
use Prueba\Entities\Detalles;
use Prueba\Repositories\HistorialRepo;
use Prueba\Repositories\ArchivoRepo;
use Prueba\Managers\DetallesManager;

class HistorialController extends BaseController {

  protected $historialRepo;
  protected $archivoRepo;


  public function __construct(HistorialRepo $historialRepo, ArchivoRepo $archivoRepo)
  {
    $this->historialRepo = $historialRepo;
    $this->archivoRepo 	= $archivoRepo;
  }

	public function index()
	{
		$datos = $this->historialRepo->all();

		$numero = array('50'=>'50', '100'=>'100', '150'=>'150');

		return View::make('mineria', compact('datos', 'numero'));

	}


}