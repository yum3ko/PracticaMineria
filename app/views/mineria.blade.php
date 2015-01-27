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
                    {{ Field::select('numero_maximo') }}

                </div>
    
                <div class="form-group col-sm-4">
                  
                    <button type="submit" class="btn btn-default btn-block">Comenzar Minería</button>
                </div>
            
            {{ Form::close() }}
        </div><!-- container-->

        <div class="container">
            <div class="table-responsive table-bordered table-striped table-hover">

                <table class="table">
                    <thead>
                        <tr class="active success">
                            <th>URL</th>
                            <th>Palabra Clave</th>
                            <th>Coincidencias</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datos as $dato)
                            <tr>
                                <td>{{ $dato->url }} </td>
                                <td>{{ $dato->palabra_clave }} </td>
                                <td>{{ $dato->coincidencias }} </td>
                                
                            </tr>
                        @endforeach
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

