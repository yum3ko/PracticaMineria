<?php
use Prueba\Entities\Detalles;
use Prueba\Repositories\DetallesRepo;
use Prueba\Repositories\ArchivoRepo;
use Prueba\Managers\DetallesManager;

class DetallesController extends BaseController {

  protected $detallesRepo;
  protected $archivoRepo;


  public function __construct(DetallesRepo $detallesRepo, ArchivoRepo $archivoRepo)
  {
    $this->detallesRepo = $detallesRepo;
    $this->archivoRepo 	= $archivoRepo;
  }

	public function index()
	{
		$datos = $this->detallesRepo->all();

		$numero = array('50'=>'50', '100'=>'100', '150'=>'150');

		return View::make('mineria', compact('datos', 'numero'));

	}
	public function store()
	{
		$detalles = $this->detallesRepo->newdetalles();
		$data = Input::all();

		$datos_dominio = $this->archivoRepo->makeArchivo($data['url']);

		if($this->archivoRepo->getArchivo($datos_dominio))
		{
			$this->archivoRepo->modifica($datos_dominio, $data['numero_maximo']);
		}

		$manager = new DetallesManager($detalles, $data);

		$manager->save();

		$status = 'Success';

		return Redirect::route('mineria');
	}


}