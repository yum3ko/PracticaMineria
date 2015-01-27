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
        $fs_archivo = fopen ($this->archivo_destino, "w"); 
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

    public function modifica($datos_dominio)
    {

        // Abrir el archivo
        
        $abrir = fopen($this->archivo_destino,'r+');
        $contenidos = fread($abrir,filesize($this->archivo_destino));
        fclose($abrir);
         
        // Separar linea por linea
        $contenidos = explode("\n",$contenidos);
         
        // Modificar lineas deseadas 
        $contador = count($contenidos);


        for( $i = 0; $i < $contador; $i++ ) 
        {
            $findA = strpos($contenidos[$i], '<a ');

            if( $findA === false )
            {
                unset($contenidos[$i]); //elimina
                $contenidos = array_values($contenidos); //recorre
                $i-=1;

                $contador = count($contenidos);
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

                $findA = strpos($contenidos[$i], '<a ');

                if( $findA !== false )
                {
                    $contenidos[]   = substr($contenidos[$i], $findA);
                    $contador       = count($contenidos);
                        
                    $contenidos[$i] = substr($contenidos[$i], 0, $findA);   
                }

            } //else
        } //fin for

        $contador = count($contenidos);

        // Unir archivo
        $contenidos = implode("\r\n",$contenidos);
         
        // Guardar Archivo
        $abrir = fopen($this->archivo_destino,'w');
        fwrite($abrir,$contenidos);
        fclose($abrir);
     
    }
}