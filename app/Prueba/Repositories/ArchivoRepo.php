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
echo 'Abriendo archivo txt <br> ';
        $archivo = '..\Public\_'.$this->archivo_destino;
        $abrir = fopen($archivo,'r+');
        $contenidos = fread($abrir,filesize($archivo));
        fclose($abrir);
         
        // Separar linea por linea
        $contenidos = explode("</a",$contenidos);
         
        // Modificar lineas deseadas 
        $contador = count($contenidos);
echo 'Al principio '.$contador.'<br>';

        for( $i = 0; $i < $contador; $i++ ) 
        {               
                $findA = strpos($contenidos[$i], '<a ');

                if( ($findA === false ) && ($i == $contador-1) )
                {
                    unset( $contenidos[$i] ); //elimina
                    $contenidos = array_values($contenidos); //vuelve indexar
                    $i-=1;

                    $contador = count($contenidos);
                    continue;
                }
                    
                else
                {
                    $contenidos[$i] = substr($contenidos[$i], $findA); //corta del principio hasta el findA

                    $caracteres_href = 6;

                    $findHref_inicio = strpos($contenidos[$i], 'href="');
                    $findHref_final  = strpos($contenidos[$i], '"', $findHref_inicio+$caracteres_href );

                    if( $findHref_inicio === false )
                    {
                        $findHref_inicio = strpos($contenidos[$i], "href='");
                        $findHref_final  = strpos($contenidos[$i], "'", $findHref_inicio+$caracteres_href );
                    }

                    if( $findHref_inicio === false )  //si no contiene atributo href: se elimina
                    {
                        $href = '';
                        continue;
                    }

                    $findHref_total = $findHref_final - ($findHref_inicio + $caracteres_href);
                    $href  = substr($contenidos[$i], $findHref_inicio+$caracteres_href, $findHref_total);

                    $perteneceDominio = strpos($href, '/');
                    if($perteneceDominio === 0)
                    {
                        $href = $datos_dominio['url_dominio'].$href;
                    }
        echo ' url: '.$href.'<br> ';
                    

                } //fin else si existe etiqueta A

                $contador = count($contenidos);
        echo 'Al final '.$contador;
                // Unir archivo
                $contenidos = implode("\r\n",$contenidos);
                 
                // Guardar Archivo
                $abrir = fopen($archivo,'w');
                fwrite($abrir,$contenidos);
                fclose($abrir);

                if( $contador == intval($num_maximo) )
                {
                    for($j = $num_maximo; $j < $contador; $j++)
                    {
                        unset($contenidos[j]);
                    }
                    break;
                }
                
        }//for contador
    }

}