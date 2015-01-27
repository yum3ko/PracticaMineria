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

		 return View::make('mineria', compact('datos'));

	}
	public function store()
	{
		$historial = $this->historialRepo->newHistorial();
		$data = Input::all();

		$this->archivoRepo->makeArchivo($data['url']);

		$this->archivoRepo->getArchivo();

		$this->archivoRepo->modifica();

		$manager = new HistorialManager($historial, $data);

		$manager->save();

		$status = 'Success';

		return Redirect::route('mineria');
	}


}
