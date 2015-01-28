<?php
use Prueba\Entities\Historial;
use Prueba\Entities\Detalles;

use Prueba\Repositories\HistorialRepo;
use Prueba\Repositories\DetallesRepo;
use Prueba\Repositories\ArchivoRepo;

use Prueba\Managers\HistorialManager;
use Prueba\Managers\DetallesManager;


class HistorialController extends BaseController {

  protected $historialRepo;
  protected $detallesRepo;
  protected $archivoRepo;


  public function __construct(HistorialRepo $historialRepo, DetallesRepo $detallesRepo, ArchivoRepo $archivoRepo)
  {
    $this->historialRepo = $historialRepo;
    $this->detallesRepo  = $detallesRepo;
    $this->archivoRepo 	 = $archivoRepo;
  }

	public function index()
	{
		$historial_id = $this->historialRepo->all()->count();

		$datos = $this->detallesRepo->getDetallesByHistorial($historial_id);

		$numero = array('50'=>'50', '100'=>'100', '150'=>'150');

		return View::make('mineria', compact('datos', 'numero'));

	}
	public function store()
	{
		$historial = $this->historialRepo->newHistorial();
		$data = Input::all();

		$datos_dominio = $this->archivoRepo->makeArchivo($data['url']);


		$historialManager = new HistorialManager($historial, $data);

		$historialManager->save();

		$historialStatus = 'Success';
		
		$historial_id = $this->historialRepo->all()->count();


		if($this->archivoRepo->getArchivo($datos_dominio))
		{
			$enlaces=$this->archivoRepo->modifica($datos_dominio, $data['numero_maximo']);

			if(count($enlaces) > 0)
			{
				$detalles = $this->detallesRepo->newDetalles();

				foreach($enlaces as $enlac){
					$enlace = extract($enlac);
					
					$dataDetalle = array(
						'url' 			=> $url,
						'palabra_clave' => $palabra_clave,
						'coincidencias' => $coincidencias,
						'historial_id'	=> $historial_id
					);

					$detallesManager = new DetallesManager($detalles, $dataDetalle);

					$detallesManager->save();

					$detallesStatus = 'Success';
				}
			}
			
		}


		return Redirect::route('mineria');
	}


}
