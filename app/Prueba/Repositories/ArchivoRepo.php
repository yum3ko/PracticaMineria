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

            if( $findHref_inicio === false )  //si no contiene atributo href: se deja en blanco
            {
                $href = '';
                continue;
            }

            $findHref_tamaño = $findHref_final - ($findHref_inicio + $caracteres_href);
            $href  = substr($contenidos[$i], $findHref_inicio+$caracteres_href, $findHref_tamaño);

            $perteneceDominio = strpos($href, '/');

            if($perteneceDominio === 0)
            {
                $href = $datos_dominio['url_dominio'].$href;
            }
        echo ' url: '.$href.'<br> ';
                                

            $contador = count($contenidos);
        
            // Unir archivo
            $contenidos = implode("\r\n",$contenidos);
                 
            // Guardar Archivo
            $abrir = fopen($archivo,'w');
            fwrite($abrir,$contenidos);
            fclose($abrir);

            echo 'contador: '.$contador;

            if( $contador == intval($num_maximo) )
            {
                for($j = $num_maximo; $j < $contador; $j++)
                {
                    unset($contenidos[$j]);
                }
                $contenidos = array_values($contenidos);
                break;
            }


            dd('numero maximo '.$num_maximo);
            dd($contenidos);

    
        }//for contador
    }

}