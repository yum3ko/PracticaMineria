<?php
namespace Prueba\Repositories;

use Prueba\Entities\Historial;
use Symfony\Component\DomCrawler\Crawler;

class ArchivoRepo {

	protected $nombre_archivo = 'temp.txt';
    protected $coincidencia  = 1;


	public function setDatos($url)
    {
        $url_dominio	= "http://".$url;
        $nombre_dominio = substr($url, 0, strpos($url, '.'));

        return compact('url_dominio', 'nombre_dominio');
    }


	public function makeArchivo($datos_dominio)
    {
        $curl = curl_init ($datos_dominio['url_dominio']);         //inicia sesion
        $fs_archivo = fopen ('..\Public\_'.$this->nombre_archivo, "w"); 
        curl_setopt ($curl, CURLOPT_FILE, $fs_archivo); //establece opciones para transferencia
        curl_setopt ($curl, CURLOPT_HEADER, 0); 
        curl_exec ($curl);								//ejecuta sesion

        if(curl_errno ($curl)===false)
        {
            return false;
        } 
        curl_close ($curl);  							//termina sesion
        fclose ($fs_archivo);

        return true;
    }


    public function getArchivo()
    {
        // Abrir el archivo
        $archivo = '..\Public\_'.$this->nombre_archivo;

        if(file_exists($archivo))
        {
            $gestor = fopen($archivo,'w+');

            if(filesize($archivo) > 0){
                $contenidos = fread($gestor, filesize($archivo));

                fclose($gestor);

                if( $contenidos != false )
                {
                    return $contenidos;
                }

            }
        }

        return false;
    }


    public function getDatos($documento)
    {

        $crawler = new Crawler($documento);

        $array = $crawler->filter('a')->each(function ($node, $i) {
            $palabra_clave[] = $node->text();
            $url[]           = $node->attr('href');
            $coincidencias[] = $this->coincidencia;

            return compact('palabra_clave', 'url', 'coincidencias');
        });

        return $array;
    }


    public function depurarDatos($datosEnlaces, $numero_maximo)
    {
        $contador = count($datosEnlaces);

            if(isset($datosEnlaces))
            {
                $enlaces[0] = $datosEnlaces[0];

                if(count($datosEnlaces) > 1)
                {
                    for($i=0; $i < $numero_maximo-1; $i++) 
                    {
                        if( in_array($enlaces, $datosEnlaces[$i]) )
                        {
                            $enlace['coincidencias'] =+ 1;                      
                        }
                        else
                        {
                            $enlaces[] = $datosEnlaces;
                        }
                    
                    }
                }
            }

        return $enlaces;
    }


    public function formatStrDato($dato)
    {
        if(is_array($dato))
        {
            $dato = implode($dato);
        }

        return $dato;
    }

    public function formatIntDato($dato)
    {
        if(is_array($dato))
        {
            $dato = implode($dato);
        }
            $dato = intval($dato);

        return $dato;
    }


}