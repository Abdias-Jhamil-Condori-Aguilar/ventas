@extends('layouts.app')

@section('title', 'Artículos')

@push('css-datatable')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush

@push('css')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')

@include('layouts.partials.alert')

<div class="bg-body-light">
  <div class="content content-full">
    <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
      <div class="flex-grow-1">
        <h1 class="h3 fw-bold mb-1">Artículos</h1>
      </div>
      <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-alt">
          <li class="breadcrumb-item">
            <a class="link-fx" href="{{ route('panel') }}">Inicio</a>
          </li>
          <li class="breadcrumb-item" aria-current="page">Artículos</li>
        </ol>
      </nav>
    </div>
  </div>

  @can('crear-articulo')
  <div class="content content-full">
    <a href="{{ route('articulos.create') }}" class="btn btn-primary">Añadir nuevo artículo</a>
  </div>
  @endcan

  <div class="content content-full">
    <div class="block block-rounded">
      <div class="block-header block-header-default">
        <h3 class="block-title">Tabla Articulos</h3>
      </div>
      <div class="block-content block-content-full">
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Categoría</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articulos as $item)
                <tr>
                    <td>{{ $item->codigo }}</td>
                    <td>{{ $item->nombre }}</td>
                    <td>{{ $item->descripcion }}</td>
                    <td>{{ $item->categoria ? ($item->categoria->caracteristica ? $item->categoria->caracteristica->nombre : 'Sin Característica') : 'Sin Categoría' }}</td>
                    <td>
                        @if ($item->estado == 1)
                        <span class="badge rounded-pill text-bg-success">Activo</span>
                        @else
                        <span class="badge rounded-pill text-bg-danger">Eliminado</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex justify-content-around">
                            <div>
                                <button title="Opciones" class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu text-bg-light" style="font-size: small;">
                                    @can('editar-articulo')
                                    <li><a class="dropdown-item" href="{{route('articulos.edit', ['articulo' => $item->id])}}">Editar</a></li>
                                    @endcan
                                    @can('ver-articulo')
                                    <li>
                                        <a class="dropdown-item" role="button" data-bs-toggle="modal" data-bs-target="#verModal-{{$item->id}}">Ver</a>
                                    </li>
                                    @endcan
                                </ul>
                            </div>
                            <div class="vr"></div>
                            <div>
                                @can('eliminar-articulo')
                                @if ($item->estado == 1)
                                <button title="Eliminar" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$item->id}}" class="btn btn-datatable btn-icon btn-transparent-dark">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                                @else
                                <button title="Restaurar" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$item->id}}" class="btn btn-datatable btn-icon btn-transparent-dark">
                                    <i class="fas fa-undo-alt"></i>
                                </button>
                                @endif
                                @endcan
                            </div>
                        </div>
                    </td>
                </tr>

                <!-- Modal Ver Detalles -->
                <div class="modal fade" id="verModal-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Detalles del Artículo</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><span class="fw-bolder">Descripción: </span>{{ $item->descripcion }}</p>
                                <p><span class="fw-bolder">Categoría: </span>{{ $item->categoria?->nombre ?? 'Sin categoría' }}</p>
                                @if($item->img_path)
                                <p class="fw-bolder">Imagen:</p>
                                <img src="{{ Storage::url('articulos/'.$item->img_path) }}" alt="{{ $item->nombre }}" class="img-fluid img-thumbnail border border-4 rounded">
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Confirmación -->
                <div class="modal fade" id="confirmModal-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmación</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                {{ $item->estado == 1 ? '¿Seguro que quieres eliminar el artículo?' : '¿Seguro que quieres restaurar el artículo?' }}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <form action="{{ route('articulos.destroy',['articulo'=>$item->id]) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Confirmar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
@endpush
