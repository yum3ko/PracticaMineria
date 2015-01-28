@extends('layout')


@section('titulo')
         Minería de Datos
@stop

@section('header')
    <h1 class="text-center">Minería</h1>

@stop


@section('contenido')
    
    <div class="panel-body">
        <div class="container">
            {{ Form::open(['route' => 'add_historial', 'method' => 'POST', 'role' => 'form']) }}

                <div class="form-group col-sm-4">
                    {{ Field::text('url') }}

                </div>

                <div class="form-group col-sm-4">    
                    {{ Field::select('numero_maximo', $numero) }}

                </div>
    
                <div class="form-group col-sm-4">
                  
                    <button type="submit" class="btn btn-default btn-block">Comenzar Minería</button>
                </div>
            
            {{ Form::close() }}
        </div><!-- container-->

        <div class="container">
            <div class="table-responsive">

                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="active success">
                            <th class="col-xs-6">URL</th>
                            <th class="col-xs-3">Palabra Clave</th>
                            <th class="col-xs-3">Coincidencias</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr>
                            <td class="col-xs-6"> </td>
                            <td class="col-xs-3"> </td>
                            <td class="col-xs-3"> </td>
                            
                        </tr>
                        
                    </tbody>
                </table>
            </div><!-- table-responsive -->
        </div>

    </div> <!-- panel body-->
@stop
@section('footer')

    <div class="container text-center">
        <p>Prueba de Dania Monserrat Brito Arroyo</p>
    </div>

@stop

