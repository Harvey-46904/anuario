@extends('voyager::master')

@section('page_title', __('Agregar Estudiante'))
@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-person"></i> {{ __('Agregar Estudiantes') }}
        </h1>
       
    </div>
@stop
@section('content')

    <div class="page-content container-fluid">
    @if (session('errors') && is_array(session('errors')))
            <div class="alert alert-danger">
                <h3>No pudimos cargar los estudiantes, encontramos estos errores</h3>
                @foreach (session('errors') as $errorsForKey)
                    @foreach ($errorsForKey as $key => $messages)
                        <div class="mb-3">
                            <strong>Fila  {{ $key }}:</strong>
                            <ul>
                                @foreach ($messages as $message)
                                    <li>{{ $message }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                @endforeach
            </div>
        @endif
        <form class="form-edit-add" role="form"
              action="{{ route('post.exel', ['id_anuario' => $id_anuario]) }}"
              method="POST" enctype="multipart/form-data" autocomplete="off">
           
            {{ csrf_field() }}

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-bordered">
                    

                        <div class="panel-body">
                       
                            <div class="form-group">
                            <label for="name">Archivo Excel de estudiantes para este anuario</label>
                               
                                <input type="file"  name="excel">
                            </div>
                            <button type="submit" class="btn btn-primary pull-right save">
                Guardar
            </button>
                        </div>
                    </div>
                </div>

               
            </div>

            
        </form>
       
    </div>
@stop
