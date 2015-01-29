@extends('layout')


@section('titulo')
         Minería: Historial General
@stop

@section('header')
    <h1 class="text-center">Historial General</h1>

@stop


@section('contenido')
    
    <div class="panel-body">
        <div class="container">
            <a href="{{ route('mineria') }}" class="btn btn-default">Hacer nueva exploración</a>
        </div><!-- container-->

        <div class="container">
            <div class="table-responsive">

                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="active success">
                            <th class="col-xs-6">ID</th>
                            <th class="col-xs-3">URL</th>
                            <th class="col-xs-3">Fecha</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datos as $dato)
                            <tr>
                                <td class="col-xs-6">{{ $dato->id }} </td>
                                <td class="col-xs-3">{{ $dato->url }} </td>
                                <td class="col-xs-3">{{ $dato->created_at }} </td>
                                
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
