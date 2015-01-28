<?php
namespace Prueba\Repositories;

use Prueba\Entities\Historial;

class ArchivoRepo {

	protected $archivo_destino = 'temp.txt';


	public function makeArchivo($url)
    {
        $url_dominio	= "http://".$url;
        $nombre_dominio = substr($url, 0, strpos($url, '.'));

        return compact('url_dominio', 'nombre_dominio');
    }


	public function getArchivo($datos_dominio)
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


    public function modifica($datos_dominio, $num_maximo)
    {
        $enlaces = array();
        $datosEnlaces = array();
        $coincidencias      = 1;

        // Abrir el archivo
        $archivo = '..\Public\_'.$this->archivo_destino;
        $abrir = fopen($archivo,'r+');
        $contenidos = fread($abrir,filesize($archivo));
        fclose($abrir);

        // Separar linea por linea
        $contenidos = explode("</a",$contenidos);
         
        // Modificar lineas deseadas 
        $contador = count($contenidos);
        for( $i = 0; $i < $contador; $i++ ) 
        {               
            $findA = strpos($contenidos[$i], '<a ');
                    
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

            $findHref_tamaño = $findHref_final - ($findHref_inicio + $caracteres_href);
            $url             = substr($contenidos[$i], $findHref_inicio+$caracteres_href, $findHref_tamaño);

            $perteneceDominio = strpos($url, '/');


            if($perteneceDominio === 0)
            {
                $url = $datos_dominio['url_dominio'].$url;
            }


            $findPalabra_inicio = strpos($contenidos[$i], ">", $findHref_final);
            $palabra_clave      = substr($contenidos[$i], $findPalabra_inicio+1);

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
            

            if( $contador == intval($num_maximo) )
            {
                for($j = $num_maximo; $j < $contador; $j++)
                {
                    unset($contenidos[$j]);
                }
                $contenidos = array_values($contenidos);
                break;
            }

            //GUARDANDO DATOS en arreglo
            $datosEnlaces = compact('url', 'palabra_clave', 'coincidencias');

            
                
            if( $i==0 )
            {
                array_unshift($enlaces, $datosEnlaces);
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

            
                //dd(array_values($enlaces));
    
        }//for contador
    
        // Unir archivo
        $contenidos = implode("\r\n",$contenidos);
                 
        // Guardar Archivo
        $abrir = fopen($archivo,'w');
        fwrite($abrir,$contenidos);
        fclose($abrir);

        //Borrar archivo
        unlink($archivo);

        return $enlaces;
    }

}