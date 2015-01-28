<?php
namespace Prueba\Repositories;

use Prueba\Entities\Historial;

class ArchivoRepo {

	protected $archivo_destino = 'temp.txt';


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
        $enlaces        = array();
        $datosEnlaces   = array();
        $coincidencias  = 1;

        // Abrir el archivo
        $archivo = '..\Public\_'.$this->archivo_destino;
        if( !($abrir = fopen($archivo,'r+')) )
        {
            return false;
        }

        $contenidos = fread($abrir,filesize($archivo));
        fclose($abrir);

        return $contenidos;
    }


    public function getDatos($contenidos, $datos_dominio, $num_maximo)
    {
        // Separar linea por linea
        $contenidos = explode("</a",$contenidos);
         
        // Modificar lineas deseadas 
        $contador = count($contenidos);

        if($num_maximo < $contador)
        {
            $num_maximo = $contador;
        }

        for( $i = 0; $i < $num_maximo; $i++ ) 
        {

            $findA = strpos($contenidos[$i], '<a ', 0);
            if($findA === false){
                continue;
            }
            $contenidos[$i] = substr($contenidos[$i], $findA); //corta del principio hasta el findA

            $caracteres_href = 6;
            $findHref_inicio = strpos($contenidos[$i], 'href="');

            if( count($contenidos[$i]) > ($findHref_inicio+$caracteres_href) )
            {
                $findHref_final  = strpos($contenidos[$i], '"', $findHref_inicio+$caracteres_href );
            }
            else
            {
                $findHref_final = 0;
            }

            if( $findHref_inicio === false )
            {
                $findHref_inicio = strpos($contenidos[$i], "href='");
                
                if( count($contenidos[$i]) > ($findHref_inicio+$caracteres_href) )
                {
                    $findHref_final  = strpos($contenidos[$i], "'", $findHref_inicio+$caracteres_href );
                }
                else
                {
                    $findHref_final = 0;
                }
            }


            if( $findHref_inicio === false )  //si no contiene atributo url: se deja en blanco
            {
                $url = '';
                continue;
            }

            $findHref_tamanno = $findHref_final - ($findHref_inicio + $caracteres_href);
            $url              = substr($contenidos[$i], $findHref_inicio+$caracteres_href, $findHref_tamanno);


            $perteneceDominio = strpos($url, '/');
            if($perteneceDominio === 0)
            {
                $url = $datos_dominio['url_dominio'].$url;
            }

            $caracter_palabra = 1;
            $findPalabra_inicio = strpos($contenidos[$i], ">", $findHref_final);
            $palabra_clave      = substr($contenidos[$i], $findPalabra_inicio+$caracter_palabra);

            $compruebaIMG       = strpos($contenidos[$i], "img", $findHref_final); 
            $caracteres_alt = 5;

            if($compruebaIMG !== false){

                $compruebaIMG  = strpos($contenidos[$i], 'alt="');
                $findAlt_final = strpos($contenidos[$i], '"', $compruebaIMG+$caracteres_alt );

                if( $compruebaIMG !== false )
                {
                    $compruebaIMG  = strpos($contenidos[$i], "alt='");
                    $findAlt_final = strpos($contenidos[$i], "'", $compruebaIMG+$caracteres_alt );
                }

                if( $compruebaIMG === false )  //si no contiene atributo alt: se elimina
                {
                    $palabra_clave = '';
                    continue;
                }
                $findAlt_total = $findAlt_final - ($compruebaIMG + $caracteres_alt);

                $palabra_clave = substr($contenidos[$i], $compruebaIMG+$caracteres_alt, $findAlt_total);
            }


            //GUARDANDO DATOS en arreglo
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
    
        }//for contador
                 
        return $enlaces;
    }


    public function deleteArchivo()
    {
        $archivo = '..\Public\_'.$this->archivo_destino;
        //Borrar archivo
        unlink($archivo);

        return true;
    }

}