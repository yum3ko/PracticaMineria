<?php

use Prueba\Entities\Detalles;

use Prueba\Repositories\HistorialRepo;
use Prueba\Repositories\DetallesRepo;
use Prueba\Repositories\ArchivoRepo;

use Prueba\Managers\HistorialManager;
use Prueba\Managers\DetallesManager;


class DetallesController extends BaseController {

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
		$numero = array('50'=>'50', '100'=>'100', '150'=>'150');

		return View::make('mineria', compact('numero'));

	}

	public function iniciado($url_iniciada)
	{

		$historial_id = $this->historialRepo->all()->count();

		$datos = $this->detallesRepo->getDetallesByHistorial($historial_id);

		$numero = array('50'=>'50', '100'=>'100', '150'=>'150');

		return View::make('mineria-iniciado', compact('datos', 'numero', 'url_iniciada'));

	}


	public function store()
	{
		$historial = $this->historialRepo->newHistorial();

		$data = Input::all();

		$numero_maximo= $data['numero_maximo'];
		$datos_dominio = $this->archivoRepo->setDatos($data['url']);


		$historialManager = new HistorialManager($historial, $data);

		$historialManager->save();

		$historialStatus = 'Success';
		
		$historial_id = $this->historialRepo->all()->count();

		$createDocumento = $this->archivoRepo->makeArchivo($datos_dominio);


		if($createDocumento)
		{
			$documento = $this->archivoRepo->getArchivo();

			if( $documento != false )
			{
				$datoEnlaces = $this->archivoRepo->getDatos($documento);

				$contEnlaces = count($datoEnlaces);

				if( $contEnlaces > 0)
				{
					$enlaces = $this->archivoRepo->depurarDatos($datoEnlaces, $numero_maximo);


					foreach($enlaces as $datosEnlace)
					{
						$enlace = extract($datosEnlace);
				
						$url 		   = $this->archivoRepo->formatStrDato($url);
						$palabra_clave = $this->archivoRepo->formatStrDato($palabra_clave);
						$coincidencias = $this->archivoRepo->formatIntDato($coincidencias);
						

						$dataDetalle = array(
							'url' 			=> $url,
							'palabra_clave' => $palabra_clave,
							'coincidencias' => $coincidencias,
							'historial_id'	=> $historial_id
						);

						$detalles = $this->detallesRepo->newDetalles();

						$detallesManager = new DetallesManager($detalles, $dataDetalle);

						$detallesManager->save();

						$detallesStatus = 'Success';
					}
				}
			}
		}
		

		$url_iniciada = $data['url'];

		return Redirect::route('mineria-iniciado', compact('url_iniciada'));
		
	}

}
