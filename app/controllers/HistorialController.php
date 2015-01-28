<?php
use Prueba\Entities\Historial;
use Prueba\Repositories\HistorialRepo;
use Prueba\Repositories\ArchivoRepo;
use Prueba\Managers\HistorialManager;

class HistorialController extends BaseController {

  protected $historialRepo;
  protected $archivoRepo;


  public function __construct(HistorialRepo $historialRepo, ArchivoRepo $archivoRepo)
  {
    $this->historialRepo = $historialRepo;
    $this->archivoRepo 	 = $archivoRepo;
  }

	public function index()
	{
		$datos = $this->historialRepo->all();

		$numero = array('50'=>'50', '100'=>'100', '150'=>'150');

		return View::make('mineria', compact('datos', 'numero'));

	}
	public function store()
	{
		$historial = $this->historialRepo->newHistorial();
		$data = Input::all();

		$datos_dominio = $this->archivoRepo->makeArchivo($data['url']);

		if($this->archivoRepo->getArchivo($datos_dominio))
		{
			$this->archivoRepo->modifica($datos_dominio, $data['numero_maximo']);
		}

		$manager = new HistorialManager($historial, $data);

		$manager->save();

		$status = 'Success';

		return Redirect::route('mineria');
	}


}
