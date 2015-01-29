<?php
namespace Prueba\Repositories;

use Prueba\Entities\Historial;
use Symfony\Component\DomCrawler\Crawler;

class ArchivoRepo {

	protected $archivo_destino = 'temp.txt';
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
        $fs_archivo = fopen ('..\Public\_'.$this->archivo_destino, "w"); 
        curl_setopt ($curl, CURLOPT_FILE, $fs_archivo); //establece opciones para transferencia
        curl_setopt ($curl, CURLOPT_HEADER, 0); 
        curl_exec ($curl);								//ejecuta sesion

        if(curl_errno ($curl)===false)
        {
            $exito = false;
        } 
        curl_close ($curl);  							//termina sesion
        fclose ($fs_archivo); 
        $exito = true;

        return $exito;
    }


    public function getArchivo()
    {
        // Abrir el archivo
        $archivo = '..\Public\_'.$this->archivo_destino;
        $exito   = $abrir = fopen($archivo,'r+');
        if( !$exito )
        {
            return false;
        }

        $contenidos = fread($abrir,filesize($archivo));
        fclose($abrir);

        return $contenidos;
    }


    public function getDatos($documento)
    {
        $crawler = new Crawler($documento);

        $array = $crawler->filter('a')->each(function ($node, $i) {
            $palabra[] = $node->text();
            $href[]  = $node->attr('href');

            return compact('palabra', 'href');
        });

        return $array;
    }


    public function depurarDatos($datosEnlaces)
    {

dd($datosEnlaces);
            
            $datosEnlaces = compact('url', 'palabra_clave', 'coincidencias');

            if(isset($datosEnlaces))
            {
                if( $i==0 )
                {
                    $enlaces[0] = $datosEnlaces;
                }
                else
                {
                    foreach($enlaces as $enlace) 
                    {
                        if( in_array($enlace, $datosEnlaces) )
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
    
      

        return true;
    }


    public function deleteArchivo()
    {
        $archivo = '..\Public\_'.$this->archivo_destino;
        //Borrar archivo
        unlink($archivo);

        return true;
    }

}